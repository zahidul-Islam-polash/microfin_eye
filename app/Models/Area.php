<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table 	= 'sys_area';
    protected $fillable = ['area_name','area_code_code','area_code_opening_date','status'];
}
