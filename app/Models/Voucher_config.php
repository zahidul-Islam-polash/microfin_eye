<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Voucher_config extends Model
{
    protected $table 	= 'voucher_id_config';
    protected $fillable = ['is_auto_generated','pv_prefix','rv_prefix','jv_prefix','ftv_prefix','segment_1','segment_2','segment_3','segment_4','auto_increment_length','code_separator','status'];
}
