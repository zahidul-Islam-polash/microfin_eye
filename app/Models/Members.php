<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    protected $table 	= 'members_info';
    protected $fillable = ['member_code','member_name','member_dob','member_age','member_gender','member_contact','status'];
}
