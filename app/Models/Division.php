<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $table 	= 'sys_division';
    protected $fillable = ['division_name','division_code','status'];
}
