<?php

// Category.php (Category model)
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Costs;


class Categories extends Model
{
    // Define the table associated with this model
    protected $table = 'categories';

    // Define relationships (if any) with other models
    // For example, if you want to associate costs with categories
    public function costs()
    {
        return $this->hasMany(Costs::class);
    }
}
