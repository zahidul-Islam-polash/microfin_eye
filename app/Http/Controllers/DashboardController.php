<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\User_types;
use Session;
use Illuminate\Support\Facades\Redirect;

class DashboardController extends Controller
{

	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		
		//echo request()->segment(1);
		//exit;
		$data = array();
		$data['heading'] 		= 'Dashboard';
		$data['Sub_heading'] 	= 'Dashboard';			
		$data['page_type'] 		= 0;			
		return view('dashboard',$data);					
    }
	
	
	public function logout()
    {
        Session::put('user_id','');
		Session::put('utype_id','');
        Session::put('branch_id','');
        Session::put('emp_id','');
        Session::put('user_name','');
        Session::put('user_photo','');
        Session::put('utype_name','');
        Session::put('exception','You are successfully Logout !');
        return Redirect::to('/');
    }
	
	
		
	
  
}
