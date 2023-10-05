<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cost;

class UpdatePaidStatusCommand extends Command
{
    protected $signature = 'expenses:update-paid-status';
    protected $description = 'Automatically update the status of upcoming expenses to "paid"';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get current date
        $currentDate = now();

        // Find upcoming expenses with due dates in the past
        $expenses = Cost::where('due_date', '<=', $currentDate)
            ->where('paid', false)
            ->get();

        // Update the status of found expenses to "paid"
        foreach ($expenses as $expense) {
            $expense->update(['paid' => true]);
        }

        $this->info('Updated the status of ' . count($expenses) . ' expenses to "paid".');
    }
}