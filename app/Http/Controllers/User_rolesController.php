<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\User_roles;
use Session;
use Illuminate\Support\Facades\Redirect;


class User_rolesController extends Controller
{

	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data = array();
		$data['colums'] 		= array("sl"=>"Sl", "role_name"=>"User Role Name", "status"=>"Status", "action"=>"Action"); 
		$data['heading'] 		= 'User Roles';
		$data['Sub_heading'] 	= 'User Roles Manager';
		$data['controller'] 	= 'User_roles';
		$data['add_button'] 	= 'Add New';	
		$data['page_type'] 		= 1	;		
		return view('settings/user_roles',$data);					
    }
	
	public function store(Request $request)
    {
        $data =array();
		$data = request()->except(['_token']);
		$data['created_by']		= Session::get('user_id');
		$data['status'] = User_roles::insertGetId($data);
		echo json_encode($data);
    }
	
	public function edit($id)
    {
		$info = DB::table('user_role')
							->where('role_id', $id)
							->first();				
		$data['role_id'] 	= $info->role_id;
		$data['role_name'] 	= $info->role_name;		
		$data['status'] 	= $info->status;		
		return $data;
    }
	
	public function update(Request $request, $id)
    {
		$data = request()->except(['_token','_method']);		
		$data['updated_by']		= Session::get('user_id');
		$update['status']         = DB::table('user_role')
            ->where('role_id', $id)
            ->update($data);
		echo json_encode($update);
    }
	

	public function all_data(Request $request)
    {       
		$columns = array( 
			0 =>'role_id', 
			1 =>'role_name',
			2=> 'status',
		);
        $totalData = User_roles::count();
        $totalFiltered = $totalData; 
        $limit 	= $request->input('length');
        $start 	= $request->input('start');
        $order 	= $columns[$request->input('order.0.column')];
        $dir 	= $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $infos = User_roles::offset($start)
							->limit($limit)
							->orderBy($order,$dir)
							->get();
        }
        else{
            $search = $request->input('search.value'); 
            $infos 	=  User_roles::where('role_name','LIKE',"%{$search}%")
							->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
            $totalFiltered = User_roles::where('role_name','LIKE',"%{$search}%")
							->count();
        }

        $data = array();
        if(!empty($infos))
        {
            $i=1;
            foreach ($infos as $info)
            {
                $nestedData['sl'] 			= $i++;
                $nestedData['role_name'] 	= $info->role_name;
				if($info->status == 1)
				{
					$status = 'Active';
				}
				else{
					$status = 'Cancelled';
				}
                $nestedData['status'] 		= $status;      
				$nestedData['action'] 		= '<button class="btn btn-sm btn-primary btn-xs"  title="Edit" onclick="edit('.$info->role_id.')"><i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i></button>';
				
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
