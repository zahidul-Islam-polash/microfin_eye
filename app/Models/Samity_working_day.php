<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Samity_working_day extends Model
{
    protected $table 	= 'samity_working_day';
    protected $fillable = ['working_day_name','status'];
}
