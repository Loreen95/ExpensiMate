<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cost;
use App\Models\Category;
use App\Services\FinanceService;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationMail;

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
        $user = auth()->user();

        // Haal dashboardData op uit FinanceService, passing the user ID
        $dashboardData = $this->financeService->getDashboardData($user);

        return view('finance.dashboard', [
            'fixedExpenses' => $this->financeService->getFixedExpenses($user),
            'variableExpenses' => $this->financeService->getVariableExpenses($user),
            'upcomingExpenses' => $this->financeService->getUpcomingExpenses($user),
            'totalCost' => $this->financeService->getTotalCost($user),
            'totalVariable' => $this->financeService->getTotalVariable($user),
        ]);
    }
    
    public function showAddForm()
    {
        $categories = $this->financeService->showAddForm();
        
        return view('finance.cost_add', compact('categories'));
    }

    public function showAddCategoryForm()
    {
        return view('finance.category_add');
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
            'cost' => 'required|numeric|between:0,999999.99',
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

    public function addCategory(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        $newCategory = $this->financeService->addCategory($validatedData);

        return redirect()->route('finance.index')->with('success', 'Category added successfully');
    }

    public function remove(Request $request, $id)
    {
        $result = $this->financeService->removeExpense($id);

        if (!$result) {
            abort(404); // or handle the not found case in your way
        }

        // Redirect back to the page with a success message or handle it as needed
        return redirect()->route('finance.index')->with('success', 'Expense removed successfully');
    }
    
    public function generateMonthlyExpensesChart()
    {
        $chartData = $this->financeService->generateMonthlyExpensesChart();

        return view('finance.graph', $chartData);
    }

    public function markAsPaid($id)
    {
        $expense = Cost::find($id);

        if (!$expense) {
            abort(404); // Handle not found case as needed
        }

        $expense->update(['paid' => true]);

        // Redirect back to the page with a success message or handle it as needed
        return redirect()->route('finance.index')->with('success', 'Expense marked as paid successfully');
    }
    public function markAsNotPaid($id)
    {
        // Find the expense by ID
        $expense = Cost::find($id);

        // Check if the expense exists
        if (!$expense) {
            abort(404); // or handle the not found case in your way
        }

        // Set the expense as "Not Paid"
        $expense->paid = false;
        $expense->save();

        // Redirect back to the page with a success message or handle it as needed
        return redirect()->route('finance.index')->with('success', 'Expense marked as Not Paid successfully');
    }

    public function getPaidBills()
    {
        $paidExpenses = $this->financeService->getPaidBills();
        return view('finance.paid-bills', compact('paidExpenses'));
    }

    public function sendTestEmail()
    {
        // Example logic to send the email with upcoming expenses
        $emailContent = 'This is a test email content.';
        $frequency = 'daily';
        $upcomingExpenses = $this->financeService->getUpcomingExpenses();
    
        // Pass $upcomingExpenses when creating the Mailable instance
        $mail = new NotificationMail($emailContent, $frequency, $upcomingExpenses);
    
        // Send the email
        Mail::to('lisahakhoff@ziggo.nl')->send($mail);
    
        // Optionally, redirect or return a response to the user
        return 'Test email sent successfully.';
    }
}