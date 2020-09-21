<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Upazila extends Model
{
    protected $table 	= 'sys_upazila';
    protected $fillable = ['upazila_name','upazila_code','district_id','status'];
}
