<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\District;
use Session;
use Illuminate\Support\Facades\Redirect;


class DistrictController extends Controller
{

	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data = array();
		$data['colums'] 		= array("sl"=>"Sl", "district_name"=>"District Name", "district_code"=>"District Code", "division_name"=>"Division",  "status"=>"Status", "action"=>"Action"); 
		$data['heading'] 		= 'District';
		$data['Sub_heading'] 	= 'District Manager';
		$data['controller'] 	= 'District';
		$data['add_button'] 	= 'Add New';	
		$data['page_type'] 		= 1	;		
		$data['divisions'] 		= DB::table('sys_division')
									->where('status', 1)
									->get();		
		return view('settings/district',$data);					
    }
	
	public function store(Request $request)
    {
        $data =array();
		$data = request()->except(['_token']);
		$data['created_by']		= Session::get('user_id');
		$created['status'] = District::insertGetId($data);
		echo json_encode($created);
    }
	
	public function edit($id)
    {
		$info = DB::table('sys_district')
							->where('district_id', $id)
							->first();				
		$data['district_id'] 	= $info->district_id;
		$data['district_name'] 	= $info->district_name;		
		$data['division_id'] 	= $info->division_id;		
		$data['district_code'] 	= $info->district_code;		
		$data['status'] 		= $info->status;		
		return $data;
    }
	
	public function update(Request $request, $id)
    {
		$data = request()->except(['_token','_method']);
		$data['updated_by']		= Session::get('user_id');		
		$update['status']         = DB::table('sys_district')
            ->where('district_id', $id)
            ->update($data);
		echo json_encode($update);
    }
	

	public function all_data(Request $request)
    {       
		$columns = array( 
			0 =>'district_id', 
			1 =>'district_name',
			1 =>'division_id',
			2 =>'district_code',
			3=> 'status',
		);
        $totalData = District::count();
        $totalFiltered = $totalData; 
        $limit 	= $request->input('length');
        $start 	= $request->input('start');
        $order 	= $columns[$request->input('order.0.column')];
        $dir 	= $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $infos = District::join('sys_division', 'sys_division.division_id', '=', 'sys_district.division_id' )
							->offset($start)
							->limit($limit)
							->orderBy($order,$dir)
							->get();
        }
        else{
            $search = $request->input('search.value'); 
            $infos 	=  District::join('sys_division', 'sys_division.division_id', '=', 'sys_district.division_id' )
							->where('district_name','LIKE',"%{$search}%")
							->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
            $totalFiltered = District::where('district_name','LIKE',"%{$search}%")
							->count();
        }

        $data = array();
        if(!empty($infos))
        {
            $i=1;
            foreach ($infos as $info)
            {
                $nestedData['sl'] 			= $i++;
                $nestedData['district_name'] 	= $info->district_name;
                $nestedData['district_code'] 	= $info->district_code;
                $nestedData['division_name'] 	= $info->division_name;
				if($info->status == 1)
				{
					$status = 'Active';
				}
				else{
					$status = 'Cancelled';
				}
                $nestedData['status'] 		= $status;      
				$nestedData['action'] 		= '<button class="btn btn-sm btn-primary btn-xs"  title="Edit" onclick="edit('.$info->district_id.')"><i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i></button>';
				
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
