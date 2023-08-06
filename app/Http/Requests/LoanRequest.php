<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\LoanTermRule;

class LoanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'loan_amount' => 'required|numeric|min:1',
            'interest_rate' => 'required|numeric|min:0.01',
            'loan_term' => ['required', 'numeric', new LoanTermRule()],
            'extra_payment' => 'nullable|numeric|min:0',
        ];
    }
}
