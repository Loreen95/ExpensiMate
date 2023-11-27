<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\User;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        // Retrieve the first user to associate categories
        $user = User::first();

        Category::create([
            'category_name' => 'Groceries',
            'user_id' => $user->id,
        ]);

        Category::create([
            'category_name' => 'Utilities',
            'user_id' => $user->id,
        ]);

        // Add more categories if needed
    }
}

