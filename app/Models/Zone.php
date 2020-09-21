<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $table 	= 'sys_zone';
    protected $fillable = ['zone_name','zone_code','zone_opening_date','status'];
}
