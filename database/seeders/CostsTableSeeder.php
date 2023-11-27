<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cost;
use App\Models\Category;
use App\Models\User;

class CostsTableSeeder extends Seeder
{
    public function run()
    {
        // Retrieve the first user and category to associate costs
        $user = User::first();
        $category = Category::first();

        Cost::create([
            'cost' => 100.00,
            'description' => 'Monthly Groceries',
            'expense_type' => 'variable',
            'due_date' => now()->addDays(7),
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);

        Cost::create([
            'cost' => 775.00,
            'description' => 'Monthly Rent',
            'expense_type' => 'fixed',
            'due_date' => now()->addDays(14),
            'category_id' => $category->id, // You may change this to another category if needed
            'user_id' => $user->id,
        ]);

        // Add more costs if needed
    }
}
