<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Zone;
use Session;
use Illuminate\Support\Facades\Redirect;


class ZoneController extends Controller
{

	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data = array();
		$data['colums'] 		= array("sl"=>"Sl", "zone_name"=>"Zone Name", "zone_code"=>"Zone Code", "zone_opening_date"=>"Opening Date", "status"=>"Status", "action"=>"Action"); 
		$data['heading'] 		= 'Zone';
		$data['Sub_heading'] 	= 'Zone Manager';
		$data['controller'] 	= 'zone';
		$data['add_button'] 	= 'Add New';	
		$data['page_type'] 		= 1	;			
		return view('settings/zone',$data);					
    }
	
	public function store(Request $request)
    {
        $data =array();
		$data = request()->except(['_token']);
		$data['created_by']		= Session::get('user_id');
		$data['status'] = Zone::insertGetId($data);
		echo json_encode($data);
    }
	
	public function edit($id)
    {
		$info = DB::table('sys_zone')
							->where('zone_id', $id)
							->first();				
		$data['zone_id'] 			= $info->zone_id;
		$data['zone_name'] 			= $info->zone_name;		
		$data['zone_code'] 			= $info->zone_code;		
		$data['zone_opening_date'] 	= $info->zone_opening_date;		
		$data['status'] 			= $info->status;		
		return $data;
    }
	
	public function update(Request $request, $id)
    {
		$data = request()->except(['_token','_method']);
		$data['updated_by']		= Session::get('user_id');		
		$update['status']         = DB::table('sys_zone')
            ->where('zone_id', $id)
            ->update($data);
		echo json_encode($update);
    }
	

	public function all_data(Request $request)
    {       
		$columns = array( 
			0 =>'zone_id', 
			1 =>'zone_name',
			1 =>'zone_code',
			2 =>'zone_opening_date',
		);
        $totalData = Zone::count();
        $totalFiltered = $totalData; 
        $limit 	= $request->input('length');
        $start 	= $request->input('start');
        $order 	= $columns[$request->input('order.0.column')];
        $dir 	= $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $infos = Zone:: offset($start)
							->limit($limit)
							->orderBy($order,$dir)
							->get();
        }
        else{
            $search = $request->input('search.value'); 
            $infos 	=  Zone::where('zone_name','LIKE',"%{$search}%")
							->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
            $totalFiltered = Zone::where('zone_name','LIKE',"%{$search}%")
							->count();
        }

        $data = array();
        if(!empty($infos))
        {
            $i=1;
            foreach ($infos as $info)
            {
                $nestedData['sl'] 					= $i++;
                $nestedData['zone_name'] 			= $info->zone_name;
				$nestedData['zone_code'] 			= $info->zone_code;
                $nestedData['zone_opening_date'] 	= $info->zone_opening_date;
                
				if($info->status == 1)
				{
					$status = 'Active';
				}
				else{
					$status = 'Cancelled';
				}
                $nestedData['status'] 		= $status;      
				$nestedData['action'] 		= '<button class="btn btn-sm btn-primary btn-xs"  title="Edit" onclick="edit('.$info->zone_id.')"><i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i></button>';
				
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
