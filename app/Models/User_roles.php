<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class User_roles extends Model
{
    protected $table 	= 'user_role';
    protected $fillable = ['role_name','status'];
}
