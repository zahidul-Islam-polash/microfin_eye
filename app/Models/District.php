<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table 	= 'sys_district';
    protected $fillable = ['district_name','division_id','district_code','status'];
}
