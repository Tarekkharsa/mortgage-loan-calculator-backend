@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Loan Setup Details:</h1>
    <p>Loan Amount: ${{ number_format($loanAmount, 2) }}</p>
    <p>Annual Interest Rate: {{ number_format($interestRate, 2) }}%</p>
    <p>Loan Term: {{ $loanTerm }} years</p>
    <p>Effective Interest Rate (Regular Schedule): {{ number_format($effectiveInterestRateRegular, 2) }}%</p>
    <p>Effective Interest Rate (Extra Repayment Schedule): {{ number_format($effectiveInterestRateExtraRepayment, 2) }}%</p>

    <h2 class="text-2xl font-bold mt-4">Amortization Schedule</h2>
    <table class="w-full border-collapse border border-gray-400">
        <thead>
            <tr>
                <th class="border border-gray-400 px-4 py-2">Month No.</th>
                <th class="border border-gray-400 px-4 py-2">Starting Balance</th>
                <th class="border border-gray-400 px-4 py-2">Monthly Payment</th>
                <th class="border border-gray-400 px-4 py-2">Principal Component</th>
                <th class="border border-gray-400 px-4 py-2">Interest Component</th>
                <th class="border border-gray-400 px-4 py-2">Ending Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($amortizationSchedule as $row)
                <tr>
                    <td class="border border-gray-400 px-4 py-2">{{ $row['month_number'] }}</td>
                    <td class="border border-gray-400 px-4 py-2">${{ number_format($row['starting_balance'], 2) }}</td>
                    <td class="border border-gray-400 px-4 py-2">${{ number_format($row['monthly_payment'], 2) }}</td>
                    <td class="border border-gray-400 px-4 py-2">${{ number_format($row['principal_component'], 2) }}</td>
                    <td class="border border-gray-400 px-4 py-2">${{ number_format($row['interest_component'], 2) }}</td>
                    <td class="border border-gray-400 px-4 py-2">${{ number_format($row['ending_balance'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="text-2xl font-bold mt-8">Extra Repayment Schedule</h2>
    <table class="w-full border-collapse border border-gray-400">
        <thead>
            <tr>
                <th class="border border-gray-400 px-4 py-2">Month No.</th>
                <th class="border border-gray-400 px-4 py-2">Starting Balance</th>
                <th class="border border-gray-400 px-4 py-2">Monthly Payment</th>
                <th class="border border-gray-400 px-4 py-2">Principal Component</th>
                <th class="border border-gray-400 px-4 py-2">Interest Component</th>
                <th class="border border-gray-400 px-4 py-2">Extra Repayment Made</th>
                <th class="border border-gray-400 px-4 py-2">Ending Balance After Extra Repayment</th>
                <th class="border border-gray-400 px-4 py-2">Remaining Loan Term After Extra Repayment</th>
            </tr>
        </thead>
        <tbody>
            @foreach($extraRepaymentSchedule as $row)
                <tr>
                    <td class="border border-gray-400 px-4 py-2">{{ $row['month_number'] }}</td>
                    <td class="border border-gray-400 px-4 py-2">${{ number_format($row['starting_balance'], 2) }}</td>
                    <td class="border border-gray-400 px-4 py-2">${{ number_format($row['monthly_payment'], 2) }}</td>
                    <td class="border border-gray-400 px-4 py-2">${{ number_format($row['principal_component'], 2) }}</td>
                    <td class="border border-gray-400 px-4 py-2">${{ number_format($row['interest_component'], 2) }}</td>
                    <td class="border border-gray-400 px-4 py-2">${{ number_format($row['extra_repayment_made'], 2) }}</td>
                    <td class="border border-gray-400 px-4 py-2">${{ number_format($row['ending_balance'], 2) }}</td>
                    <td class="border border-gray-400 px-4 py-2">{{ $row['remaining_loan_term'] }} months</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
