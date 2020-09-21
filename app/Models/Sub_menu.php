<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Sub_menu extends Model
{
    protected $table 	= 'user_sub_menu';
    protected $fillable = ['sub_menu_name','menu_id','style_css','has_sub_menu','sub_menu_link','sub_menu_sl','status'];
}
