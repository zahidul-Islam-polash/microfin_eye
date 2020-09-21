<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Member_samity_transfer extends Model
{
    protected $table 	= 'member_samity_transfer';
    protected $fillable = ['member_id','transfer_date','current_branch','new_samity','new_member_code','status'];
}
