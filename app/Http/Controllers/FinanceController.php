<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cost;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    public function dashboard()
    {
        // Retrieve fixed expenses with related categories from the database
        $fixedExpenses = Cost::with('category')
            ->where('expense_type', 'fixed')
            ->get();

        $totalCost = 0;

        foreach ($fixedExpenses as $expense) {
            $totalCost += $expense->cost;
        }

        // Retrieve variable expenses with related categories from the database
        $variableExpenses = Cost::with('category')
            ->where('expense_type', 'variable')
            ->get();

        $totalVariable = 0;

        foreach ($variableExpenses as $expense) {
            $totalVariable += $expense->cost;
        }

        $upcomingExpenses = Cost::with('category')
        ->selectRaw('*, DATE_FORMAT(due_date, "%d-%m-%Y") as formatted_due_date')
        ->where('due_date', '>', DB::raw('CURDATE()'))
        ->where('due_date', '<=', DB::raw('DATE_ADD(CURDATE(), INTERVAL 14 DAY)'))
        ->get();

        // Calculate budget vs. actual (example calculation)
        $budgetVsActual = ""; // Your budget vs. actual calculation logic here;

        return view('finance.dashboard', [
            'fixedExpenses' => $fixedExpenses,
            'variableExpenses' => $variableExpenses,
            'budgetVsActual' => $budgetVsActual,
            'totalCost' => $totalCost,
            'totalVariable' => $totalVariable,
            'upcomingExpenses' => $upcomingExpenses,
            // 'generalExpenses' => $generalExpenses,
            // 'translatedCategories' => $translatedCategories,
        ]);
    }
    public function edit(Request $request, $id)
    {
        // Retrieve the expense with the given ID from your database
        $expense = Cost::find($id);

        // Retrieve all categories
        $categories = Category::all();

        // Check if the expense exists
        if (!$expense) {
            abort(404); // or handle the not found case in your way
        }

        return view('finance.edit', [
            'expense' => $expense,
            'categories' => $categories, // Pass the categories to the view
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'category_id' => 'required|integer',
            'cost' => 'required|numeric',
            'description' => 'nullable|string|max:255',
            'due_date' => 'required|date',
        ]);

        // Find the expense by its ID
        $expense = Cost::find($id);

        // Check if the expense exists
        if (!$expense) {
            abort(404); // or handle the not found case in your way
        }

        // Update expense details
        $expense->category_id = $validatedData['category_id'];
        $expense->cost = $validatedData['cost'];
        $expense->description = $validatedData['description'];
        $expense->due_date = $validatedData['due_date'];

        // Save the updated expense
        $expense->save();

        return redirect()->route('finance.dashboard')->with('success', 'Expense updated successfully');
    }

    public function addCost(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'cost' => 'required|numeric',
            'description' => 'nullable|string|max:255',
            'expense_type' => 'required|in:fixed,variable',
            'due_date' => 'required|date',
            'category_id' => 'required|integer',
        ]);

        // Create a new cost record
        $cost = new Cost();
        $cost->cost = $validatedData['cost'];
        $cost->description = $validatedData['description'];
        $cost->expense_type = $validatedData['expense_type'];
        $cost->due_date = $validatedData['due_date'];
        $cost->category_id = $validatedData['category_id'];
        // Save the cost to the database
        $cost->save();

        // Redirect back to the page with a success message or handle it as needed
        return redirect()->route('finance.dashboard')->with('success', 'Expense added successfully');
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

        return redirect()->route('finance.dashboard')->with('success', 'Category added successfully');
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
        return redirect()->route('finance.dashboard')->with('success', 'Expense removed successfully');
    }

    public function generateMonthlyExpensesChart()
    {
        // Retrieve the total costs per month from the database
        $monthlyCosts = DB::table('costs')
            ->select(DB::raw('MONTH(due_date) as month'), DB::raw('SUM(cost) as total_cost'), 'expense_type')
            ->groupBy(DB::raw('MONTH(due_date)'), 'expense_type')
            ->orderBy(DB::raw('MONTH(due_date)'))
            ->get();

        // Initialize arrays for labels and data
        $labels = [];
        $data = [];

        // Loop through each month to populate labels and data arrays
        for ($month = 1; $month <= 12; $month++) {
            $monthName = trans("months." . strtolower(date('F', mktime(0, 0, 0, $month, 1))));
            $labels[] = $monthName;

            // Initialize variables for fixed and variable costs
            $fixedCost = 0;
            $variableCost = 0;

            // Loop through the retrieved data to calculate costs for each month
            foreach ($monthlyCosts as $cost) {
                if ($cost->month == $month) {
                    if ($cost->expense_type === 'fixed') {
                        $fixedCost = $cost->total_cost;
                    } elseif ($cost->expense_type === 'variable') {
                        $variableCost = $cost->total_cost;
                    }
                }
            }

            // Push the calculated costs to the data array
            $data[] = [
                'fixed' => $fixedCost,
                'variable' => $variableCost,
            ];
        }

        return view('finance/graph', compact('labels', 'data'));
    }

}