<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanCalculatorController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/calculate-loan', [LoanCalculatorController::class, 'calculateLoan']);
Route::post('/calculate-loan-amortization', [LoanCalculatorController::class, 'calculateLoanAmortization']);
Route::post('/calculate-loan-extra-repayment', [LoanCalculatorController::class, 'calculateExtraRepaymentSchedule']);
