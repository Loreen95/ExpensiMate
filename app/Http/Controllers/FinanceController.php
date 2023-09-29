<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Costs;

class FinanceController extends Controller
{
    //
    public function index(){
        return view('finance.dashboard');
    }
    
    public function showFixedExpenses()
    {
        // Retrieve fixed expenses from the database
        $fixedExpenses = Costs::where('expense_type', 'fixed')->get();

        return view('finance.dashboard', ['fixedExpenses' => $fixedExpenses]);
    }
}
