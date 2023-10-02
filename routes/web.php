<?php

use App\Http\Controllers\FinanceController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/financeboard', [FinanceController::class, 'dashboard'])->name('finance.dashboard');

Route::get('/finance/edit/{id}', [FinanceController::class, 'edit'])->name('finance.edit');
Route::put('/finance/edit/{id}', [FinanceController::class, 'update'])->name('finance.update');

Route::get('/finance/cost_add', [FinanceController::class, 'showAddForm'])->name('finance.cost_add');
Route::post('/finance/cost_add', [FinanceController::class, 'addCost'])->name('finance.cost_add.post');

Route::get('/finance/category/add', [FinanceController::class, 'showAddCategoryForm'])->name('finance.category_add');
Route::post('/finance/category/add', [FinanceController::class, 'addCategory'])->name('finance.category_add.post');

Route::delete('/finance/remove/{id}', [FinanceController::class, 'remove'])->name('finance.remove');

Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');


require __DIR__.'/auth.php';
