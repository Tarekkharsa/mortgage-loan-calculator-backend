@extends('layouts.app')


@section('content')
@if($errors->any())
    {!! implode('', $errors->all('<span class="text text-danger">:message</span>')) !!}
@endif
    <h1 class="text-2xl font-bold mb-4">Mortgage Loan Calculator</h1>
    <form method="POST" action="{{ route('loan.calculate') }}" class="space-y-4">
        @csrf
        <label for="loan_amount" class="block">Loan Amount:</label>
        <input type="number" name="loan_amount" id="loan_amount" required class="border border-gray-400 px-4 py-2 rounded-md w-full">

        <label for="interest_rate" class="block">Annual Interest Rate (%):</label>
        <input type="number" name="interest_rate" id="interest_rate" step="0.01" required class="border border-gray-400 px-4 py-2 rounded-md w-full">

        <label for="loan_term" class="block">Loan Term (in years):</label>
        <input type="number" name="loan_term" id="loan_term" required class="border border-gray-400 px-4 py-2 rounded-md w-full">

        <label for="extra_payment" class="block">Monthly Fixed Extra Repayment (optional):</label>
        <input value="0" type="number" name="extra_payment" id="extra_payment" step="0.01" class="border border-gray-400 px-4 py-2 rounded-md w-full">

        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md">Calculate</button>
    </form>
@endsection
