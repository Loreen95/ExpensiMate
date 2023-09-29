<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cost;
use App\Models\Category;
use App\Http\Controllers\LanguageController;

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

        // Calculate budget vs. actual (example calculation)
        $budgetVsActual = ""; // Your budget vs. actual calculation logic here;

        // // Retrieve user's selected language (you may have your own logic for this)
        // $selectedLanguage = session('locale'); // Replace with your logic to get the user's selected language

        // // Retrieve expense categories for translation
        // $expenseCategories = Category::all();

        // // Translate the expense categories dynamically based on the user's selected language
        // $translatedCategories = [];
        // foreach ($expenseCategories as $category) {
        //     $translatedCategories[$category->category_name] = trans('dashboard.category_names' . $category->category_name, [], $selectedLanguage);
        // }

        return view('finance.dashboard', [
            'fixedExpenses' => $fixedExpenses,
            'variableExpenses' => $variableExpenses,
            'budgetVsActual' => $budgetVsActual,
            'totalCost' => $totalCost,
            'totalVariable' => $totalVariable,
            // 'translatedCategories' => $translatedCategories,
        ]);
    }
}