<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table 	= 'user_menu';
    protected $fillable = ['menu_name','nav_id','style_css','has_sub_menu','menu_link','menu_sl','status'];
}
