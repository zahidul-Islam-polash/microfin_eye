<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Loan_config extends Model
{
    protected $table 	= 'loan_config';
    protected $fillable = ['interest_cal_method','is_another_method_allowed','is_multiple_loan_allow_primary','status'];
}
