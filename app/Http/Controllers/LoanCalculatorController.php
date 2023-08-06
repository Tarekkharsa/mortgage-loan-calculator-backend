<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LoanCalculatorService;

class LoanCalculatorController extends Controller
{
    private $loanCalculatorService;

    public function __construct(LoanCalculatorService $loanCalculatorService)
    {
        $this->loanCalculatorService = $loanCalculatorService;
    }

    public function calculateLoan(Request $request)
    {
        // Validate the input values to ensure they are valid
        $request->validate([
            'loan_amount' => 'required|numeric|min:1',
            'annual_interest_rate' => 'required|numeric|min:0',
            'loan_term' => 'required|integer|min:1',
            'monthly_fixed_extra_payment' => 'numeric|min:0',
        ]);

        // Get the user input
        $loanAmount = $request->input('loan_amount');
        $annualInterestRate = $request->input('annual_interest_rate');
        $loanTerm = $request->input('loan_term');
        $monthlyFixedExtraPayment = $request->input('monthly_fixed_extra_payment', 0);

        // Calculate the loan amortization schedule
        $amortizationSchedule = $this->loanCalculatorService->calculateLoanAmortizationSchedule($loanAmount, $annualInterestRate, $loanTerm, $monthlyFixedExtraPayment);

        // Calculate the extra repayment schedule
        $extraRepaymentSchedule = $this->loanCalculatorService->calculateExtraRepaymentSchedule($loanAmount, $annualInterestRate, $loanTerm, $monthlyFixedExtraPayment);

        // Return the response
        return response()->json([
            'amortization_schedule' => $amortizationSchedule,
            'extra_repayment_schedule' => $extraRepaymentSchedule,
        ]);
    }

    public function calculateLoanAmortization(Request $request)
    {
        // Validate the input values to ensure they are valid
        $request->validate([
            'loan_amount' => 'required|numeric|min:1',
            'annual_interest_rate' => 'required|numeric|min:0',
            'loan_term' => 'required|integer|min:1',
            'monthly_fixed_extra_payment' => 'numeric|min:0',
        ]);

        // Get the user input
        $loanAmount = $request->input('loan_amount');
        $annualInterestRate = $request->input('annual_interest_rate');
        $loanTerm = $request->input('loan_term');
        $monthlyFixedExtraPayment = $request->input('monthly_fixed_extra_payment', 0);

        // Calculate the loan amortization schedule
        $amortizationSchedule = $this->loanCalculatorService->calculateLoanAmortizationSchedule(
            $loanAmount,
            $annualInterestRate,
            $loanTerm,
            $monthlyFixedExtraPayment
        );

        // Return the response (you can use a view or JSON response, depending on your needs)
        return response()->json($amortizationSchedule);
    }

    public function calculateExtraRepaymentSchedule(Request $request)
    {
        // Validate the input values to ensure they are valid
        $request->validate([
            'loan_amount' => 'required|numeric|min:1',
            'annual_interest_rate' => 'required|numeric|min:0',
            'loan_term' => 'required|integer|min:1',
            'monthly_fixed_extra_payment' => 'numeric|min:0',
        ]);

        // Get the user input
        $loanAmount = $request->input('loan_amount');
        $annualInterestRate = $request->input('annual_interest_rate');
        $loanTerm = $request->input('loan_term');
        $monthlyFixedExtraPayment = $request->input('monthly_fixed_extra_payment', 0);

        // Calculate the extra repayment schedule
        $extraRepaymentSchedule = $this->loanCalculatorService->calculateExtraRepaymentSchedule(
            $loanAmount,
            $annualInterestRate,
            $loanTerm,
            $monthlyFixedExtraPayment
        );

        // Return the response (you can use a view or JSON response, depending on your needs)
        return response()->json($extraRepaymentSchedule);
    }
}
