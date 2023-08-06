<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class LoanTermRule implements Rule
{
    public function passes($attribute, $value)
    {
        // Implement the validation logic for the loan term
        // ...

        // For this example, we'll assume the loan term must be between 1 and 50 years
        return $value >= 1 && $value <= 50;
    }

    public function message()
    {
        return 'The :attribute must be between 1 and 50 years.';
    }
}
