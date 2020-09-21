<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Nav_menu extends Model
{
    protected $table 	= 'user_nav_menu';
    protected $fillable = ['nav_name','style_class','has_menu','nav_link','nav_sl','status'];
}
