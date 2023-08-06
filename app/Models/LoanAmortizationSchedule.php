<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanAmortizationSchedule extends Model
{
    use HasFactory;
    protected $table = 'loan_amortization_schedule'; // Make sure this matches the actual table name

    protected $fillable = [
        'month_number', // Add any other attributes here that can be mass assigned
        'starting_balance',
        'monthly_payment',
        'principal_component',
        'interest_component',
        'ending_balance',
    ];
}
