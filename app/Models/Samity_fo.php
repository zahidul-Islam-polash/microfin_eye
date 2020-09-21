<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Samity_fo extends Model
{
    protected $table 	= 'samity_fo';
    protected $fillable = ['samity_id','fo_id','from_date','status'];
}
