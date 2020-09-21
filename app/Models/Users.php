<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table 	= 'user_user';
    protected $fillable = ['utype_id','branch_id','user_photo','user_name','password','status'];
}
