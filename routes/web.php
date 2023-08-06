<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FinalTestController;
use Inertia\Inertia;

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


Route::get('/loan-calculator', [FinalTestController::class, 'showLoanCalculator'])->name('loan.calculator');
Route::post('/loan-calculation', [FinalTestController::class, 'calculateLoan'])->name('loan.calculate');