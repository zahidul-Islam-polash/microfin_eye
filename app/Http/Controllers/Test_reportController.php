<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Redirect;

class Test_reportController extends Controller
{

	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data = array();
		$data['heading'] 		= 'TEST PAGE';
		$data['Sub_heading'] 	= 'Report';			
		$data['page_type'] 		= 0;			
		return view('templates/report_sample',$data);					
    }
	
	

		
	
  
}
