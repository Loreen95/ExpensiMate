<?php

namespace app\Services;

use App\Models\Cost;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class FinanceService
{
    public $totalCost = 0;
    public $totalVariable = 0;

    public function getDashboardData()
    {
        $dashboardData = [
            'fixedExpenses' => $this->getFixedExpenses(),
            'variableExpenses' => $this->getVariableExpenses(),
            'upcomingExpenses' => $this->getUpcomingExpenses(),
            'totalCost' => $this->getTotalCost(),
            'totalVariable' => $this->getTotalVariable(),
        ];
    }

    public function getFixedExpenses()
    {
        // Retrieve fixed expenses with related categories from the database
        $fixedExpenses = Cost::with('category')
        ->where('expense_type', 'fixed')
        ->get();

        foreach ($fixedExpenses as $expense) {
            $this->totalCost += $expense->cost;
        }
        return $fixedExpenses;
    }

    public function getVariableExpenses()
    {        
        // Retrieve variable expenses with related categories from the database
        $variableExpenses = Cost::with('category')
            ->where('expense_type', 'variable')
            ->get();

        foreach ($variableExpenses as $expense) {
            $this->totalVariable += $expense->cost;
        }
        return $variableExpenses;
    }

    public function getUpcomingExpenses()
    {
        // Retrieve upcoming expenses
        $upcomingExpenses = Cost::with('category')
            ->selectRaw('*, DATE_FORMAT(due_date, "%d-%m-%Y") as formatted_due_date')
            ->where('due_date', '>', DB::raw('CURDATE()'))
            ->where('due_date', '<=', DB::raw('DATE_ADD(CURDATE(), INTERVAL 14 DAY)'))
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
        $expense = Cost::find($id);

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
        $expense = Cost::find($id);

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

        // Save the cost to the database
        $cost->save();

        return $cost; // Return the newly created cost
    }

    
}