<?php

namespace app\Services;

use App\Models\Cost;
use App\Models\Category;
use App\Models\Receipt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FinanceService
{
    public $totalCost = 0;
    public $totalVariable = 0;

    public function getDashboardData()
    { 
        $totalCost = 0;
        $totalVariable = 0;
        $dashboardData = [
            'fixedExpenses' => $this->getFixedExpenses(),
            'variableExpenses' => $this->getVariableExpenses(),
            'upcomingExpenses' => $this->getUpcomingExpenses(),
            'totalCost' => $this->getTotalCost(),
            'totalVariable' => $this->getTotalVariable(),
        ];
    }

    public function showAddForm()
    {
        $user = auth()->user();
        $categories = Category::where('user_id', $user->id)->get();
        
        return $categories;
    }

    public function getFixedExpenses()
    {
        // Retrieve fixed expenses with related categories for the currently authenticated user
        $fixedExpenses = Cost::with('category')
            ->where('expense_type', 'fixed')
            ->where('user_id', auth()->id()) // Filter by user ID
            ->get();

        foreach ($fixedExpenses as $expense) {
            $this->totalCost += $expense->cost;
        }

        return $fixedExpenses;
    }

    public function getVariableExpenses()
    {
        // Retrieve variable expenses with related categories for the currently authenticated user
        $variableExpenses = Cost::with('category')
            ->where('expense_type', 'variable')
            ->where('user_id', auth()->id()) // Filter by user ID
            ->get();

        foreach ($variableExpenses as $expense) {
            $this->totalVariable += $expense->cost;
        }

        return $variableExpenses;
    }

    public function getUpcomingExpenses()
    {
        // Retrieve upcoming expenses for the currently authenticated user
        $upcomingExpenses = Cost::with('category')
        ->selectRaw('*, DATE_FORMAT(due_date, "%d-%m-%Y") as formatted_due_date')
        ->where('due_date', '>', DB::raw('CURDATE()'))
        ->where('due_date', '<=', DB::raw('DATE_ADD(CURDATE(), INTERVAL 14 DAY)'))
        ->where('user_id', auth()->id()) // Filter by user ID
        ->get();

        return $upcomingExpenses;
    }

    public function getTotalCost()
    {
        return $this->totalCost;
    }

    public function getTotalVariable()
    {
        return $this->totalVariable;
    }

    public function getExpenseForEdit($id)
    {
        $user = auth()->user();

        // Find the expense with the given ID that belongs to the authenticated user
        $expense = Cost::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$expense) {
            return null;
        }

        $categories = Category::all();

        return [
            'expense' => $expense,
            'categories' => $categories,
        ];
    }

    public function updateExpense($id, array $validatedData)
    {
        $user = auth()->user();
        
        $expense = Cost::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$expense) {
            return null;
        }

        $expense->category_id = $validatedData['category_id'];
        $expense->cost = $validatedData['cost'];
        $expense->description = $validatedData['description'];
        $expense->due_date = $validatedData['due_date'];
        $expense->save();

        return $expense;
    }

    public function addExpense(array $validatedData)
    {
        // Create a new cost record
        $cost = new Cost();
        $cost->cost = $validatedData['cost'];
        $cost->description = $validatedData['description'];
        $cost->expense_type = $validatedData['expense_type'];
        $cost->due_date = $validatedData['due_date'];
        $cost->category_id = $validatedData['category_id'];
        
        // Set the user ID for the expense
        $cost->user_id = auth()->id(); // Assuming you are using Laravel's built-in authentication
        
        // Save the cost to the database
        $cost->save();

        return $cost; // Return the newly created cost
    }

    public function addCategory(array $validatedData)
    {
        $category = new Category();
        $category->category_name = $validatedData['category_name'];

        $category->user_id = Auth::id();

        $category->save();
    }

    public function removeExpense($id)
    {
        // Find the expense by ID
        $expense = Cost::find($id);

        // Check if the expense exists
        if (!$expense) {
            return false; // Indicate that the expense was not found
        }

        // Delete the expense
        $expense->delete();

        return true; // Indicate successful removal
    }
    public function generateMonthlyExpensesChart()
    {
        // Get the currently authenticated user's ID
        $userId = auth()->id();

        // Retrieve the total costs per month and category for the specific user
        $monthlyCosts = DB::table('costs')
            ->join('categories', 'costs.category_id', '=', 'categories.id')
            ->select(
                DB::raw('MONTH(costs.due_date) as month'),
                DB::raw('SUM(costs.cost) as total_cost'),
                'costs.expense_type',
                'category_name as category'
            )
            ->where('costs.user_id', $userId) // Filter by user_id
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

            // Create a dataset for the category with the random background color and matching solid border color
            $datasets[] = [
                'label' => $category,
                'data' => $categoryData,
                'borderWidth' => 2,
            ];
        }
        return compact('labels', 'datasets');
    }

    public function getPaidBills()
    {
        // Retrieve paid expenses for the current user
        $paidExpenses = Cost::with('category')
            ->where('user_id', auth()->id())
            ->selectRaw('*, DATE_FORMAT(due_date, "%d-%m-%Y") as formatted_due_date')
            ->where('paid', 1)
            ->get();

            return $paidExpenses;
    }

    public function getReceipt()
    {
        // Retrieve expenses with media information for the currently authenticated user
        $receipts = Receipt::all();
        return $receipts;
    }
}