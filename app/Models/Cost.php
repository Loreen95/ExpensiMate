<?php

// Cost.php (Cost model)
namespace App\Models;

use App\Models\Category; // Import the Category model

use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    // Define the table associated with this model
    protected $table = 'costs';

    // Define relationships (if any) with other models
    // For example, if you want to associate costs with categories
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function showFixedExpenses()
    {
        // Retrieve fixed expenses from the database
        $fixedExpenses = Cost::where('expense_type', 'fixed')->get();

        return view('finance.dashboard', ['fixedExpenses' => $fixedExpenses]);
    }

}

