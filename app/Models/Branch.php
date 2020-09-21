<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table 	= 'sys_branch';
    protected $fillable = ['branch_name','branch_code','branch_opening_date','status'];
}
