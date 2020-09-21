<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;

class LoginController extends Controller
{

	public function __construct() 
	{
		$this->middleware("CheckSession");
	}
	
	public function index()
    {

		return view('login');
    }
	
    public function adminLoginCheck(Request $request) 
    {
		$user_name 	= $request->input('user_name');
        $password	= md5($request->input('password'));
		
        $user_info 		= DB::table('user_user')                    
						->join('user_type', 'user_type.id', '=', 'user_user.utype_id')
						->select('user_user.*','user_type.utype_name')
						->where('user_user.user_name',$user_name)
						->where('user_user.password',$password)
						->first();
					 
					 
		if($user_info)
        {
            Session::put('user_id',$user_info->user_id);
            Session::put('utype_id',$user_info->utype_id);
            Session::put('branch_id',$user_info->branch_id);
			Session::put('emp_id',$user_info->emp_id);
            Session::put('user_name',$user_info->user_name);
            Session::put('user_photo','public/uploads/users/'.$user_info->user_photo);
            Session::put('utype_name',$user_info->utype_name);
			return Redirect::to('/dashboard');
        }
		else
		{
			Session::put('exception','User Id Or Password Invalid !');
			return Redirect::to('/');
		}
    }


	


}
