<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cost;
use App\Models\Category;
use App\Services\FinanceService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    // Connect met de FinanceService
    protected $financeService;

    public function __construct(FinanceService $financeService)
    {
        $this->financeService = $financeService;
    }

    public function index()
    {
        // Haal dashboardData op uit FinanceService
        $dashboardData = $this->financeService->getDashboardData();

        return view('finance.dashboard', [
            'fixedExpenses' => $this->financeService->getFixedExpenses(),
            'variableExpenses' => $this->financeService->getVariableExpenses(),
            'upcomingExpenses' => $this->financeService->getUpcomingExpenses(),
            'totalCost' => $this->financeService->getTotalCost(),
            'totalVariable' => $this->financeService->getTotalVariable(),
        ]);
    }

    public function edit($id)
    {
        // Laat de aanpas-pagina zien
        $editData = $this->financeService->getExpenseForEdit($id);

        if ($editData === null) {
            return redirect()->route('finance.index')->with('error', 'Expense not found');
        }
        return view('finance.edit', $editData);
    }

    public function update(Request $request, $id)
    {
        // Update de gegevens
        $validatedData = $request->validate([
            'category_id' => 'required|integer',
            'cost' => 'required|numeric',
            'description' => 'nullable|string|max:255',
            'due_date' => 'required|date',
        ]);
        $updatedExpense = $this->financeService->updateExpense($id, $validatedData);

        if ($updatedExpense === null) {
            return redirect()->route('finance.index')->with('error', 'Expense not found');
        }
        return redirect()->route('finance.index')->with('success', 'Expense updated successfully');
    }

    public function addCost(Request $request)
    {
        // Voeg nieuwe gegevens toe
        $validatedData = $request->validate([
            'cost' => 'required|numeric',
            'description' => 'nullable|string|max:255',
            'expense_type' => 'required|in:fixed,variable',
            'due_date' => 'required|date',
            'category_id' => 'required|integer',
        ]);

        // Add a new cost using the FinanceService
        $newCost = $this->financeService->addExpense($validatedData);

        // Redirect back to the page with a success message or handle it as needed
        return redirect()->route('finance.index')->with('success', 'Expense added successfully');
    }

    
    public function showAddForm()
    {
        $categories = Category::all(); // Assuming you have a "Category" model

        return view('finance.cost_add', compact('categories'));
    }

    public function showAddCategoryForm()
    {
        return view('finance.category_add');
    }

    public function addCategory(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        // Create a new category instance
        $category = new Category();
        $category->category_name = $validatedData['category_name'];

        // Associate the currently authenticated user with the category
        $category->user_id = Auth::id(); // Using the auth() helper

        // Save the category
        $category->save();

        return redirect()->route('finance.index')->with('success', 'Category added successfully');
    }

    public function remove(Request $request, $id)
    {
        // Find the expense by ID
        $expense = Cost::find($id);

        // Check if the expense exists
        if (!$expense) {
            abort(404); // or handle the not found case in your way
        }

        // Delete the expense
        $expense->delete();

        // Redirect back to the page with a success message or handle it as needed
        return redirect()->route('finance.index')->with('success', 'Expense removed successfully');
    }
    
    public function generateMonthlyExpensesChart()
    {
        // Retrieve the total costs per month and category from the database, joining with the categories table
        $monthlyCosts = DB::table('costs')
            ->join('categories', 'costs.category_id', '=', 'categories.id')
            ->select(
                DB::raw('MONTH(costs.due_date) as month'),
                DB::raw('SUM(costs.cost) as total_cost'),
                'costs.expense_type',
                'category_name as category'
            )
            ->groupBy(DB::raw('MONTH(costs.due_date)'), 'costs.expense_type', 'category_name')
            ->orderBy(DB::raw('MONTH(costs.due_date)'))
            ->get();
    
        // Initialize arrays for labels and datasets
        $labels = [];
        $datasets = [];
    
        // Get unique categories
        $categories = $monthlyCosts->pluck('category')->unique();
    
        // Loop through each month to populate labels
        for ($month = 1; $month <= 12; $month++) {
            $monthName = trans("months." . strtolower(date('F', mktime(0, 0, 0, $month, 1))));
            $labels[] = $monthName;
        }
        
        $usedColors = []; // Initialize an array to keep track of used colors

        // Loop through unique categories to create datasets
        foreach ($categories as $category) {
            $categoryData = [];
        
            // Loop through each month
            for ($month = 1; $month <= 12; $month++) {
                $monthlyCost = $monthlyCosts->where('category', $category)->where('month', $month)->first();
                $categoryData[] = $monthlyCost ? $monthlyCost->total_cost : 0;
            }
        
            do {
                // Generate a random color with 75% opacity for each category
                $randomColor = 'rgba(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ', 0.75)';
            } while (in_array($randomColor, $usedColors)); // Check if the color is already used
        
            $usedColors[] = $randomColor; // Add the generated color to the used colors array
        
            // Create a dataset for the category with the random background color and matching solid border color
            $datasets[] = [
                'label' => $category,
                'data' => $categoryData,
                'backgroundColor' => $randomColor,
                'borderColor' => preg_replace('/[^,\d]/', '', $randomColor) . ', 1)', // Matching border color with 100% solid opacity
                'borderWidth' => 2,
            ];
        }
        return view('finance.graph', compact('labels', 'datasets'));
    }
}
        // $usedColors = []; // Initialize an array to keep track of used colors

        // // Loop through unique categories to create datasets
        // foreach ($categories as $category) {
        //     do {
        //         // Generate a random color with 75% opacity for each category
        //         $randomColor = 'rgba(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255);
        //     } while (in_array($randomColor, $usedColors)); // Check if the color is already used

        //     $usedColors[] = $randomColor; // Add the generated color to the used colors array

        //     $categoryData = [];

        //     // Loop through each month
        //     for ($month = 1; $month <= 12; $month++) {
        //         $monthlyCost = $monthlyCosts->where('category', $category)->where('month', $month)->first();
        //         $categoryData[] = $monthlyCost ? $monthlyCost->total_cost : 0;
        //     }

        //     // Create a dataset for the category with the random background color and matching solid border color
        //     $datasets[] = [
        //         'label' => $category,
        //         'data' => $categoryData,
        //         'backgroundColor' => $randomColor,
        //         'borderColor' => preg_replace('/[^,\d]/', '', $randomColor) . ', 1)', // Matching border color with 100% solid opacity
        //         'borderWidth' => 1,
        //     ];
        // }
        // Pass the data to the view
//         return view('finance.graph', compact('labels', 'datasets'));
//     }
// }