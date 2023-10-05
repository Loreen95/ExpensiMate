<?php

// Cost.php (Cost model)
namespace App\Models;

use App\Models\Category; // Import the Category model

use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    // Define the table associated with this model
    protected $table = 'costs';

    protected $fillable = [
        'cost',
        'description',
        'expense_type',
        'due_date',
        'category_id',
        'paid',
    ];
        
    // Define relationships (if any) with other models
    // For example, if you want to associate costs with categories
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // In your Cost model, define the user relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function showFixedExpenses()
    {
        // Retrieve fixed expenses from the database
        $fixedExpenses = Cost::where('expense_type', 'fixed')->get();

        return view('finance.dashboard', ['fixedExpenses' => $fixedExpenses]);
    }
}

