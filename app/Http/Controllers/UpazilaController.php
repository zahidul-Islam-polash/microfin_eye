<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Upazila;
use Session;
use Illuminate\Support\Facades\Redirect;


class UpazilaController extends Controller
{

	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data = array();
		$data['colums'] 		= array("sl"=>"Sl", "upazila_name"=>"Upazila Name", "upazila_code"=>"Upazila Code", "district_name"=>"District",  "status"=>"Status", "action"=>"Action"); 
		$data['heading'] 		= 'Upazila';
		$data['Sub_heading'] 	= 'Upazila Manager';
		$data['controller'] 	= 'upazila';
		$data['add_button'] 	= 'Add New';	
		$data['page_type'] 		= 1	;		
		$data['districts'] 		= DB::table('sys_district')
									->where('status', 1)
									->get();		
		return view('settings/upazila',$data);					
    }
	
	public function store(Request $request)
    {
        $data =array();
		$data = request()->except(['_token']);
		$data['created_by']		= Session::get('user_id');
		$data['status'] = Upazila::insertGetId($data);
		echo json_encode($data);
    }
	
	public function edit($id)
    {
		$info = DB::table('sys_upazila')
							->where('upazila_id', $id)
							->first();				
		$data['upazila_id'] 	= $info->upazila_id;
		$data['upazila_name'] 	= $info->upazila_name;		
		$data['district_id'] 	= $info->district_id;		
		$data['upazila_code'] 	= $info->upazila_code;		
		$data['status'] 		= $info->status;		
		return $data;
    }
	
	public function update(Request $request, $id)
    {
		$data = request()->except(['_token','_method']);
		$data['updated_by']		= Session::get('user_id');		
		$update['status']         = DB::table('sys_upazila')
            ->where('district_id', $id)
            ->update($data);
		echo json_encode($update);
    }
	

	public function all_data(Request $request)
    {       
		$columns = array( 
			0 =>'upazila_id', 
			1 =>'upazila_name',
			1 =>'district_id',
			2 =>'upazila_code',
		);
        $totalData = Upazila::count();
        $totalFiltered = $totalData; 
        $limit 	= $request->input('length');
        $start 	= $request->input('start');
        $order 	= $columns[$request->input('order.0.column')];
        $dir 	= $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $infos = Upazila::join('sys_district', 'sys_district.district_id', '=', 'sys_upazila.district_id' )
							->offset($start)
							->limit($limit)
							->orderBy($order,$dir)
							->get();
        }
        else{
            $search = $request->input('search.value'); 
            $infos 	=  Upazila::join('sys_district', 'sys_district.district_id', '=', 'sys_upazila.district_id' )
							->where('upazila_name','LIKE',"%{$search}%")
							->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
            $totalFiltered = Upazila::where('upazila_name','LIKE',"%{$search}%")
							->count();
        }

        $data = array();
        if(!empty($infos))
        {
            $i=1;
            foreach ($infos as $info)
            {
                $nestedData['sl'] 			= $i++;
                $nestedData['upazila_name'] 	= $info->upazila_name;
                $nestedData['upazila_code'] 	= $info->upazila_code;
                $nestedData['district_name'] 	= $info->district_name;
				if($info->status == 1)
				{
					$status = 'Active';
				}
				else{
					$status = 'Cancelled';
				}
                $nestedData['status'] 		= $status;      
				$nestedData['action'] 		= '<button class="btn btn-sm btn-primary btn-xs"  title="Edit" onclick="edit('.$info->upazila_id.')"><i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i></button>';
				
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
