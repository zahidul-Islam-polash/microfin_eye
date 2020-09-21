<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Users;
use Session;
use Illuminate\Support\Facades\Redirect;


class UsersController extends Controller
{

	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data = array();
		$data['colums'] 		= array("sl"=>"Sl", "utype_id"=>"User Type", "branch_id"=>"Branch", "emp_id"=>"Employee", "user_photo"=>"Photo", "status"=>"Status", "action"=>"Action"); 
		$data['heading'] 		= 'Users';
		$data['Sub_heading'] 	= 'Users Manager';
		$data['controller'] 	= 'users';
		$data['add_button'] 	= 'Add New';	
		$data['page_type'] 		= 1	;	
		return view('templates/list',$data);					
    }
	
	public function create()
	{
		$data = array();
		$data['heading'] 				= 'Users';
		$data['Sub_heading'] 			= 'Users Manager';
		$data['button'] 				= 'Save';	
		$data['page_type'] 				= 2	;	
		$data['action'] 				= 'users';
		$data['method_control'] 		= ''; 	
		//
		$data['branches'] 				= DB::table('sys_branch')
											->where('status', 1)
											->get();
		$data['user_types'] 			= DB::table('user_type')
											->where('status', 1)
											->get();
		$data['user_id'] 				= '';
		$data['utype_id'] 				= '';
		$data['branch_id'] 				= '';
		$data['user_photo'] 			= 'public/uploads/users/no_photo.png';
		$data['emp_id'] 				= '';
		$data['user_name'] 				= '';
		$data['password'] 				= '';
		$data['status'] 				= 1;
		return view('settings/users',$data);	
	}
	
	public function store(Request $request)
    {
        $data =array();
		$data = request()->except(['_token','_method']);
		$data['password']		= md5($request->input('password'));
		$data['created_by']		= Session::get('user_id');
		if($request->file('user_photo'))
		{
			$photoName = time().'.'.$request->user_photo->getClientOriginalExtension();
			$request->user_photo->move(public_path('uploads/users/'), $photoName);
		}
		else
		{
			$photoName = '';
		}
		$data['user_photo']		= $photoName;
		$status = Users::insertGetId($data);
		return Redirect::to('/users');
    }
	
	public function update(Request $request, $id)
    {
		$data =array();
		$data = request()->except(['_token','_method']);
		if($request->file('user_photo'))
		{
			$photoName = time().'.'.$request->user_photo->getClientOriginalExtension();
			$request->user_photo->move(public_path('uploads/users/'), $photoName);
			$data['user_photo']	= $photoName;
		}
		$data['password']		= md5($request->input('password'));
		$data['updated_by']		= Session::get('user_id');;
		$status         		= DB::table('user_user')
									->where('user_id', $id)
									->update($data);
		return Redirect::to('/users');	
    }
	
	public function edit($id)
    {
		$data = array();
		$data['heading'] 				= 'Users';
		$data['Sub_heading'] 			= 'Users Manager';
		$data['button'] 				= 'Update';	
		$data['page_type'] 				= 2	;	
		$data['action'] 				= "/users/$id";
		$data['method_control'] 		= "<input type='hidden' name='_method' value='PUT' />"; 
		$info 							= DB::table('user_user')
											->where('user_id', $id)
											->first();	
		//
		$data['branches'] 				= DB::table('sys_branch')
											->where('status', 1)
											->get();
		$data['user_types'] 			= DB::table('user_type')
											->where('status', 1)
											->get();
		$data['user_id'] 				= $info->user_id;
		$data['utype_id'] 				= $info->utype_id;
		$data['branch_id'] 				= $info->branch_id;
		if($info->user_photo)
		{
			$data['user_photo'] 			= 'public/uploads/users/'.$info->user_photo;
		}else{
			$data['user_photo'] 			= 'public/uploads/users/no_photo.png';
		}
		$data['emp_id'] 				= $info->emp_id;
		$data['user_name'] 				= $info->user_name;
		$data['password'] 				= '';
		$data['status'] 				= $info->status;
		return view('settings/users',$data);
    }

	public function all_data(Request $request)
    {       
		$segment = 'users';
		$columns = array( 
			0 =>'user_id', 
			1 =>'utype_id',
			2 =>'branch_id',
			3 =>'emp_id',
			4 =>'status',
		);
        $totalData = Users::count();
        $totalFiltered = $totalData; 
        $limit 	= $request->input('length');
        $start 	= $request->input('start');
        $order 	= $columns[$request->input('order.0.column')];
        $dir 	= $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $infos = Users::leftjoin('user_type', 'user_type.id', '=', 'user_user.utype_id' )
							->leftjoin('sys_branch', 'sys_branch.branch_code', '=', 'user_user.branch_id' )
							->offset($start)
							->limit($limit)
							->orderBy($order,$dir)
							->get();
        }
        else{
            $search = $request->input('search.value'); 
            $infos 	=  Users::leftjoin('user_type', 'user_type.id', '=', 'user_user.utype_id' )
							->leftjoin('sys_branch', 'sys_branch.branch_code', '=', 'user_user.branch_id' )
							->where('emp_id','LIKE',"%{$search}%")
							->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
            $totalFiltered = Users::where('emp_id','LIKE',"%{$search}%")
							->count();
        }

        $data = array();
        if(!empty($infos))
        {
            $i=1;
            foreach ($infos as $info)
            {
                $nestedData['sl'] 			= $i++;
                $nestedData['utype_id'] 	= $info->utype_name;
                $nestedData['branch_id'] 	= $info->branch_name;
                $nestedData['emp_id'] 		= $info->emp_id;
				if($info->user_photo)
				{
					$user_photo = $info->user_photo;
				}
				else{
					$user_photo = 'no_photo.png';
				}
                $nestedData['user_photo'] 	= '<img class="img-rounded height-30" src="public/uploads/users/'.$user_photo.'">' ;
				if($info->status == 1)
				{
					$status = 'Active';
				}
				else{
					$status = 'Cancelled';
				}
                $nestedData['status'] 		= $status;      
				$nestedData['action'] 		= '<a class="btn btn-sm btn-success btn-xs" title="Edit" href="'.$segment.'/'.$info->user_id.'/edit"><i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i> Edit</a>';	
				
				$data[] = $nestedData;
            }
        }
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
    }
	
	

	
	
		
	
  
}
