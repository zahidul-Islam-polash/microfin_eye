<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Member_closing extends Model
{
    protected $table 	= 'member_closing';
    protected $fillable = ['member_id','closing_date','note','status'];
}
