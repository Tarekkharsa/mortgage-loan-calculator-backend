<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoanRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FinalTestController extends Controller
{
    public function showLoanCalculator()
    {
        return view('loan_calculator');
    }

    public function calculateLoan(LoanRequest $request)
    {

            // Validate input values
            $validator = Validator::make($request->all(), [
                'loan_amount' => 'required|numeric|min:0',
                'interest_rate' => 'required|numeric|min:0',
                'loan_term' => 'required|numeric|min:0',
                'extra_payment' => 'numeric|min:0',
            ]);
    
            if ($validator->fails()) {
                // You can return a custom response or perform any action you want
                return redirect()->back()->withErrors($validator->errors())->withInput();

                // return response()->json(['message' => 'Validation failed.', 'errors' => $validator->errors()], 422);
            }
        // Validate the input data using the LoanRequest class

        // Get the validated loan setup data
        $loanAmount = $request->input('loan_amount');
        $interestRate = $request->input('interest_rate');
        $loanTerm = $request->input('loan_term');
        $extraPayment = $request->input('extra_payment', 0); // Default to 0 if not provided

        // Calculate the monthly payment amount using the private method
        $monthlyPayment = $this->calculateMonthlyPayment($loanAmount, $interestRate, $loanTerm);

        // Generate and store the regular amortization schedule
        $regularAmortizationSchedule = $this->generateAmortizationSchedule($loanAmount, $interestRate, $loanTerm, $monthlyPayment, 0);
        $effectiveInterestRateRegular = $this->calculateEffectiveInterestRate($regularAmortizationSchedule);

        // Store the regular amortization schedule data in the database table
        DB::table('loan_amortization_schedule')->insert($regularAmortizationSchedule);

        // Generate and store the extra repayment schedule
        $extraRepaymentSchedule = $this->calculateExtraRepaymentSchedule($loanAmount, $interestRate, $loanTerm, $monthlyPayment, $extraPayment);
        $effectiveInterestRateExtraRepayment = $this->calculateEffectiveInterestRate($extraRepaymentSchedule);

        // Store the extra repayment schedule data in the database table
        DB::table('extra_repayment_schedule')->insert($extraRepaymentSchedule);

        // Return the response with the calculated data
        return view('loan_calculation_result', [
            'monthlyPayment' => $monthlyPayment,
            'loanAmount' => $loanAmount,
            'interestRate' => $interestRate,
            'loanTerm' => $loanTerm,
            'effectiveInterestRateRegular' => $effectiveInterestRateRegular,
            'effectiveInterestRateExtraRepayment' => $effectiveInterestRateExtraRepayment,
            'amortizationSchedule' => $regularAmortizationSchedule,
            'extraRepaymentSchedule' => $extraRepaymentSchedule,
        ]);
    }

    private function calculateMonthlyPayment(float $loanAmount, float $interestRate, int $loanTerm): float
    {
        // Implement the logic to calculate the monthly payment
        // Monthly interest rate = (Annual interest rate / 12) / 100
        // Number of months = Loan term * 12
        // Monthly payment = (Loan amount * Monthly interest rate) / (1 - (1 + Monthly interest rate)^(-Number of months))
        // ...

        // For this example, we'll use a simplified formula (without considering the compounding frequency) to calculate the monthly payment
        $monthlyInterestRate = ($interestRate / 12) / 100;
        $numberOfMonths = $loanTerm * 12;
        $monthlyPayment = ($loanAmount * $monthlyInterestRate) / (1 - (1 + $monthlyInterestRate)**(-$numberOfMonths));

        return round($monthlyPayment, 2);
    }

    private function generateAmortizationSchedule(float $loanAmount, float $interestRate, int $loanTerm, float $monthlyPayment, float $extraPayment): array
    {
        // Implement the logic to generate the amortization schedule
        // ...

        // For this example, we'll use a simplified amortization calculation (without considering the compounding frequency)
        $amortizationSchedule = [];
        $balance = $loanAmount;

        for ($month = 1; $month <= $loanTerm * 12; $month++) {
            $monthlyInterest = $balance * ($interestRate / 12) / 100;

            // Calculate the monthly principal component (including extra repayments)
            $monthlyPrincipal = $monthlyPayment - $monthlyInterest + $extraPayment;

            // If the extra payment is greater than the remaining balance, adjust it to the balance
            if ($monthlyPrincipal > $balance) {
                $monthlyPrincipal = $balance;
            }

            $endingBalance = $balance - $monthlyPrincipal;

            // Store the amortization data in the array
            $amortizationSchedule[] = [
                'month_number' => $month,
                'starting_balance' => $balance,
                'monthly_payment' => $monthlyPayment,
                'principal_component' => $monthlyPrincipal,
                'interest_component' => $monthlyInterest,
                'ending_balance' => $endingBalance,
            ];

            // Update the balance for the next iteration
            $balance = $endingBalance;
        }

        return $amortizationSchedule;
    }

    private function calculateExtraRepaymentSchedule(float $loanAmount, float $interestRate, int $loanTerm, float $monthlyPayment, float $extraPayment): array
    {
        // Implement the logic to calculate the extra repayment schedule
        // ...

        // For this example, we'll use a simplified amortization calculation (without considering the compounding frequency)
        $extraRepaymentSchedule = [];
        $balance = $loanAmount;
        $remainingLoanTerm = $loanTerm * 12;

        for ($month = 1; $month <= $loanTerm * 12; $month++) {
            $monthlyInterest = $balance * ($interestRate / 12) / 100;

            // Calculate the monthly principal component (including extra repayments)
            $monthlyPrincipal = $monthlyPayment - $monthlyInterest + $extraPayment;

            // If the extra payment is greater than the remaining balance, adjust it to the balance
            if ($monthlyPrincipal > $balance) {
                $monthlyPrincipal = $balance;
            }

            $endingBalance = $balance - $monthlyPrincipal;

            // Store the extra repayment schedule data in the array
            $extraRepaymentSchedule[] = [
                'month_number' => $month,
                'starting_balance' => $balance,
                'monthly_payment' => $monthlyPayment,
                'principal_component' => $monthlyPrincipal,
                'interest_component' => $monthlyInterest,
                'extra_repayment_made' => $extraPayment,
                'ending_balance' => $endingBalance,
                'remaining_loan_term' => $remainingLoanTerm,
            ];

            // Update the balance and remaining loan term for the next iteration
            $balance = $endingBalance;
            $remainingLoanTerm--;
        }

        return $extraRepaymentSchedule;
    }

    private function calculateEffectiveInterestRate(array $schedule): float
    {
        // Implement the logic to calculate the effective interest rate based on the remaining loan balance after each repayment
        // ...
    
        // For this example, we'll use a simplified formula to calculate the effective interest rate
        $count = count($schedule);
    
        // Validate if the schedule is not empty and the last record's ending balance is not zero
        if ($count > 0 && $schedule[$count - 1]['ending_balance'] > 0) {
            $lastRecord = end($schedule);
            $effectiveInterestRate = (($lastRecord['monthly_payment'] * $count) - $lastRecord['ending_balance']) / ($lastRecord['ending_balance'] * $count) * 12 * 100;
    
            return round($effectiveInterestRate, 2);
        }
    
        return 0; // Return 0 if the schedule is empty or the last record's ending balance is zero
    }
    
}
