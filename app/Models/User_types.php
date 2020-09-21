<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class User_types extends Model
{
    protected $table 	= 'user_type';
    protected $fillable = ['utype_name','status'];
}
