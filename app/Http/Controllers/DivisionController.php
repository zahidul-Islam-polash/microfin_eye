<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Division;
use Session;
use Illuminate\Support\Facades\Redirect;


class DivisionController extends Controller
{

	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data = array();
		$data['colums'] 		= array("sl"=>"Sl", "division_name"=>"Division Name", "division_code"=>"Division Name", "status"=>"Status", "action"=>"Action"); 
		$data['heading'] 		= 'Division';
		$data['Sub_heading'] 	= 'Division Manager';
		$data['controller'] 	= 'Division';
		$data['add_button'] 	= 'Add New';	
		$data['page_type'] 		= 1	;		
		return view('settings/division',$data);					
    }
	
	public function store(Request $request)
    {
        $data =array();
		$data = request()->except(['_token']);
		$data['created_by']		= Session::get('user_id');
		$data['status'] = Division::insertGetId($data);
		echo json_encode($data);
    }
	
	public function edit($id)
    {
		$info = DB::table('sys_division')
							->where('division_id', $id)
							->first();				
		$data['division_id'] 	= $info->division_id;
		$data['division_name'] 	= $info->division_name;		
		$data['division_code'] 	= $info->division_code;		
		$data['status'] 	= $info->status;		
		return $data;
    }
	
	public function update(Request $request, $id)
    {
		$data = request()->except(['_token','_method']);	
		$data['updated_by']		= Session::get('user_id');		
		$update['status']         = DB::table('sys_division')
            ->where('division_id', $id)
            ->update($data);
		echo json_encode($update);
    }
	

	public function all_data(Request $request)
    {       
		$columns = array( 
			0 =>'division_id', 
			1 =>'division_name',
			1 =>'division_code',
			2=> 'status',
		);
        $totalData = Division::count();
        $totalFiltered = $totalData; 
        $limit 	= $request->input('length');
        $start 	= $request->input('start');
        $order 	= $columns[$request->input('order.0.column')];
        $dir 	= $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $infos = Division::offset($start)
							->limit($limit)
							->orderBy($order,$dir)
							->get();
        }
        else{
            $search = $request->input('search.value'); 
            $infos 	=  Division::where('division_name','LIKE',"%{$search}%")
							->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
            $totalFiltered = Division::where('division_name','LIKE',"%{$search}%")
							->count();
        }

        $data = array();
        if(!empty($infos))
        {
            $i=1;
            foreach ($infos as $info)
            {
                $nestedData['sl'] 			= $i++;
                $nestedData['division_name'] 	= $info->division_name;
                $nestedData['division_code'] 	= $info->division_code;
				if($info->status == 1)
				{
					$status = 'Active';
				}
				else{
					$status = 'Cancelled';
				}
                $nestedData['status'] 		= $status;      
				$nestedData['action'] 		= '<button class="btn btn-sm btn-primary btn-xs"  title="Edit" onclick="edit('.$info->division_id.')"><i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i></button>';
				
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
