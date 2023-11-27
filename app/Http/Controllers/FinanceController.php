<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cost;
use App\Models\Category;
use App\Models\NotificationPreference;
use App\Services\FinanceService;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationMail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Receipt;

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

    public function showAddReceiptForm()
    {
        return view('finance.receipt_add');
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

        // Pass $emailContent to the view as a data variable
        $data = [
            'emailContent' => $emailContent,
            'frequency' => $frequency,
            'upcomingExpenses' => $upcomingExpenses,
        ];


        // Create a Mailable instance using the custom view
        $mail = new NotificationMail($data, $frequency, $upcomingExpenses);

        // Send the email
        Mail::to('lisahakhoff@ziggo.nl')->send($mail);

        // Optionally, redirect or return a response to the user
        // return 'Test email sent successfully.';
        return view('notification.emails.notification', $data);
    }

    public function addExpense(Request $request)
    {
        $data = $request->validate([
            'cost' => 'required|numeric|between:0,999999.99',
            'description' => 'nullable|string|max:255',
            'expense_type' => 'required|in:fixed,variable',
            'due_date' => 'required|date',
            'category_id' => 'required|integer',
        ]);

        // Call the addExpense function in the FinanceService
        $addedExpense = $this->financeService->addExpense($data);

        return response()->json(['message' => 'Expense added successfully', 'expense' => $addedExpense], 201);
    }

    public function getExpenses()
    {

        // Retrieve expenses for the authenticated user
        $expenses = Cost::all();
    
        return response()->json(['expenses' => $expenses], 200);
    }

    public function generateStatistics()
    {
        // Calculate the total expenses for the authenticated user
        $totalExpenses = Cost::all()->sum('amount');
    
        return response()->json(['total_expenses' => $totalExpenses], 200);
    }

     // DRINGEND : php artisan storage:link moet je doen voor images om gedisplayed te worden. Anders werkt het NIET!
    public function addReceipt(Request $request)
    {
        $request->file('media')->storeAs('public/images/post-media', 'post_' . time() . '.jpg');
        $filePath = 'storage/images/post-media/' . 'post_' . time() . '.jpg';

        $receipt = new Receipt([
            'media' => $filePath,
            'user_id' => Auth::id(),
        ]);

        $receipt->save();
        return redirect()->route('finance.receipt_list');
    }

    public function receiptList()
    {
        $receipts = $this->financeService->getReceipt();

        return view('finance.receipt_list', compact('receipts'));
    }
}