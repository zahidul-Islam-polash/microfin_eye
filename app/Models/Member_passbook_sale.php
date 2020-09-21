<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Member_passbook_sale extends Model
{
    protected $table 	= 'member_passbook_sale';
    protected $fillable = ['member_id','sale_date','passbook_no','amount','status'];
}
