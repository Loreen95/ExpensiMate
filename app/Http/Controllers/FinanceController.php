<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cost;
use App\Models\Category;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
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

        // Save the updated expense
        $expense->save();

        return redirect()->route('finance.edit', ['id' => $expense->id])->with('success', 'Expense updated successfully');
    }

    public function add(Request $request)
    {
        // Validate the incoming request data, adjust the rules as needed
        $validatedData = $request->validate([
            'category_id' => 'required|integer',
            'cost' => 'required|numeric',
            'description' => 'nullable|string|max:255',
            'due_date' => 'required|date',
        ]);

        // Create a new expense record
        $expense = new Cost();
        $expense->category_id = $validatedData['category_id'];
        $expense->cost = $validatedData['cost'];
        $expense->description = $validatedData['description'];
        $expense->due_date = $validatedData['due_date'];
        $expense->save();

        // Redirect back to the page with a success message or handle it as needed
        return redirect()->back()->with('success', 'Expense added successfully');
    }

    public function showAddForm()
    {
        $categories = Category::all(); // Assuming you have a "Category" model

        // Retrieve distinct expense types from the "costs" table
        $expenseTypes = Cost::distinct('expense_type')->pluck('expense_type');

        return view('finance.add', compact('categories', 'expenseTypes'));
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

        return redirect()->back()->with('success', 'Category added successfully');
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
        return redirect()->back()->with('success', 'Expense removed successfully');
    }
}