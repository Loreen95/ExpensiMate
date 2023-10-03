<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;
use App\Models\Category;
use App\Models\Cost;
use Lang;

class ExportLangFile extends Command
{
    protected $signature = 'export:lang';

    protected $description = 'Export data to a lang file';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $categories = Category::all();
        $costs = Cost::all();

        $langDataEN = [];
        $langDataNL = []; // Separate array for Dutch translation

        foreach ($categories as $category) {
            $langDataEN["category_{$category->id}"] = $category->category_name;
            $langDataNL["category_{$category->id}"] = $category->category_name; // Assign the same value for Dutch
        }

        foreach ($costs as $cost) {
            $langDataEN["cost_{$cost->id}"] = $cost->description;
            $langDataNL["cost_{$cost->id}"] = $cost->description; // Assign the same value for Dutch
        }

        $langFilePathEN = base_path('lang/en/sql_translations.php');
        File::put($langFilePathEN, '<?php return ' . var_export($langDataEN, true) . ';');

        $langFilePathNL = base_path('lang/nl/sql_translations.php'); // Use a separate file for Dutch
        File::put($langFilePathNL, '<?php return ' . var_export($langDataNL, true) . ';');

        $this->info('Lang files have been exported.');
    }
}
