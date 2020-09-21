<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Samity extends Model
{
    protected $table 	= 'samity_samity';
    protected $fillable = ['branch_id','samity_name','samity_code','max_member','min_member','member_type','samity_type','samity_opening_date','samity_closing_date','samity_lat','samity_lon','status'];
}
