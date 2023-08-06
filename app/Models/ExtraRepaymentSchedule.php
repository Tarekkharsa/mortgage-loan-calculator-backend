<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraRepaymentSchedule extends Model
{
    use HasFactory;
    protected $table = 'extra_repayment_schedule'; // Make sure this matches the actual table name

    protected $fillable = [
        'month_number',
        'starting_balance',
        'monthly_payment',
        'principal_component',
        'interest_component',
        'extra_repayment_made',
        'ending_balance_after_extra_repayment',
        'remaining_loan_term_after_extra_repayment',
    ];
}
