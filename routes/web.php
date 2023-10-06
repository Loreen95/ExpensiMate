<?php

use App\Http\Controllers\FinanceController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Services\FinanceService;
use App\Http\Controllers\NotificationsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationMail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/financeboard', [FinanceController::class, 'index'])->name('finance.index');
    
    Route::get('/finance/edit/{id}', [FinanceController::class, 'edit'])->name('finance.edit');
    Route::put('/finance/edit/{id}', [FinanceController::class, 'update'])->name('finance.update');
    
    Route::get('/finance/cost_add', [FinanceController::class, 'showAddForm'])->name('finance.cost_add');
    Route::post('/finance/cost_add', [FinanceController::class, 'addCost'])->name('finance.cost_add.post');

    Route::get('/finance/category/add', [FinanceController::class, 'showAddCategoryForm'])->name('finance.category_add');
    Route::post('/finance/category/add', [FinanceController::class, 'addCategory'])->name('finance.category_add.post');

    Route::delete('/finance/remove/{id}', [FinanceController::class, 'remove'])->name('finance.remove');

    Route::get('/finance/graph', [FinanceController::class, 'generateMonthlyExpensesChart'])->name('finance.graph');

    Route::put('/finance/markAsPaid/{id}', [FinanceController::class, 'markAsPaid'])->name('finance.markAsPaid');
    Route::put('/finance/markAsNotPaid/{id}', [FinanceController::class, 'markAsNotPaid'])->name('finance.markAsNotPaid');

    Route::get('/finance/paid-bills', [FinanceController::class, 'getPaidBills'])->name('finance.paid-bills');

    // Display the notification preferences settings form
    Route::get('/notification/preferences', [NotificationsController::class, 'index'])->name('notification.preferences');

    // Handle form submissions to update notification preferences
    Route::post('/notification/preferences', [NotificationsController::class, 'update'])->name('notification.preferences.update');
});



Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

Route::get('/send-test-email', [FinanceController::class, 'sendTestEmail']);

require __DIR__.'/auth.php';
