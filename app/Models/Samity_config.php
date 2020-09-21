<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Samity_config extends Model
{
    protected $table 	= 'samity_config';
    protected $fillable = ['samity_config_id','max_member_per_samity','is_show_loan_product','status'];
}
