<?php

namespace App\Services;

use App\Models\LoanAmortizationSchedule;
use App\Models\ExtraRepaymentSchedule;

class LoanCalculatorService
{
    public function calculateLoanAmortizationSchedule($loanAmount, $annualInterestRate, $loanTerm, $monthlyFixedExtraPayment = 0)
    {
        $monthlyInterestRate = ($annualInterestRate / 12) / 100;
        $numberOfMonths = $loanTerm * 12;
        $monthlyPayment = ($loanAmount * $monthlyInterestRate) / (1 - pow(1 + $monthlyInterestRate, -$numberOfMonths));

        $amortizationSchedule = [];

        $currentBalance = $loanAmount;
        for ($month = 1; $month <= $numberOfMonths; $month++) {
            $interestPayment = $currentBalance * $monthlyInterestRate;
            $principalPayment = $monthlyPayment - $interestPayment;

            $amortizationSchedule[] = [
                'month_number' => $month,
                'starting_balance' => $currentBalance,
                'monthly_payment' => $monthlyPayment,
                'principal_component' => $principalPayment,
                'interest_component' => $interestPayment,
                'ending_balance' => $currentBalance - $principalPayment,
            ];

            $currentBalance -= $principalPayment;

            // Apply the monthly fixed extra payment
            if ($monthlyFixedExtraPayment > 0) {
                $currentBalance -= $monthlyFixedExtraPayment;
            }
        }

        // Store the amortization schedule in the database
        foreach ($amortizationSchedule as $schedule) {
            LoanAmortizationSchedule::create($schedule);
        }

        return $amortizationSchedule;
    }

    public function calculateExtraRepaymentSchedule($loanAmount, $annualInterestRate, $loanTerm, $monthlyFixedExtraPayment)
    {
        $monthlyInterestRate = ($annualInterestRate / 12) / 100;
        $numberOfMonths = $loanTerm * 12;
        $monthlyPayment = ($loanAmount * $monthlyInterestRate) / (1 - pow(1 + $monthlyInterestRate, -$numberOfMonths));

        $extraRepaymentSchedule = [];

        $currentBalance = $loanAmount;
        for ($month = 1; $month <= $numberOfMonths; $month++) {
            $interestPayment = $currentBalance * $monthlyInterestRate;
            $principalPayment = $monthlyPayment - $interestPayment;

            $extraRepaymentMade = 0;
            if ($monthlyFixedExtraPayment > 0) {
                $extraRepaymentMade = $monthlyFixedExtraPayment;
                $currentBalance -= $monthlyFixedExtraPayment;
            }

            $extraRepaymentSchedule[] = [
                'month_number' => $month,
                'starting_balance' => $currentBalance,
                'monthly_payment' => $monthlyPayment,
                'principal_component' => $principalPayment,
                'interest_component' => $interestPayment,
                'extra_repayment_made' => $extraRepaymentMade,
                'ending_balance_after_extra_repayment' => $currentBalance - $principalPayment - $extraRepaymentMade,
                'remaining_loan_term_after_extra_repayment' => $numberOfMonths - $month,
            ];

            $currentBalance -= $principalPayment;
        }

        // Store the extra repayment schedule in the database
        foreach ($extraRepaymentSchedule as $schedule) {
            ExtraRepaymentSchedule::create($schedule);
        }

        return $extraRepaymentSchedule;
    }
}
