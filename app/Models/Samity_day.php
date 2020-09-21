<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Samity_day extends Model
{
    protected $table 	= 'samity_day';
    protected $fillable = ['samity_id','day_id','from_date','status'];
}
