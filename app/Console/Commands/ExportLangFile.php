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

        $langData = [];

        foreach ($categories as $category) {
            $langData["category_{$category->id}"] = $category->category_name;
        }

        foreach ($costs as $cost) {
            $langData["cost_{$cost->id}"] = $cost->description;
        }

        $langFilePath = base_path('lang/en/sql_translations.php');
        File::put($langFilePath, '<?php return ' . var_export($langData, true) . ';');

        $langFilePath1 = base_path('lang/nl/sql_translations.php');
        File::put($langFilePath, '<?php return ' . var_export($langData, true) . ';');

        $this->info('Lang file has been exported.');
    }
}
