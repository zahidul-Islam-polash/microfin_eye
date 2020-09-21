<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Area;
use Session;
use Illuminate\Support\Facades\Redirect;


class AreaController extends Controller
{

	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data = array();
		$data['colums'] 		= array("sl"=>"Sl", "area_name"=>"Area Name", "area_code"=>"Area Code", "area_opening_date"=>"Opening Date", "status"=>"Status", "action"=>"Action"); 
		$data['heading'] 		= 'Area';
		$data['Sub_heading'] 	= 'Area Manager';
		$data['controller'] 	= 'area';
		$data['add_button'] 	= 'Add New';	
		$data['page_type'] 		= 1	;
		$data['zones'] 			= DB::table('sys_zone')
											->where('status', 1)
											->get();		
		return view('settings/area',$data);					
    }
	
	public function store(Request $request)
    {
        $data =array();
		$data = request()->except(['_token','zone_id']);
		$data['created_by']			= Session::get('user_id');
		//
		$zone_area =array();
		$zone_area['zone_id'] 		= $request->input('zone_id');
		$zone_area['from_date'] 	= $request->input('area_opening_date');
		$zone_area['to_date'] 		= $request->input('area_closing_date');
		$zone_area['status'] 		= $request->input('status');
		$zone_area['created_by'] 	= Session::get('user_id');

		//START TRANSECTION 
		DB::beginTransaction();
		try {				
			//INSERT INTO sys_area TABLE
			$area_id = Area::insertGetId($data);
			//INSERT INTO sys_zone_area TABLE
			$zone_area['area_id'] 		= $area_id;
			DB::table('sys_zone_area')->insert($zone_area);
			//COMMIT DB
			DB::commit();
			//PUSH SUCCESS MESSAGE
			$success = true;
		} catch (\Exception $e) {
			//DB ROLLBACK
			DB::rollback();
			$success = false;
		}
		//END TRANSECTION 
		echo json_encode($success);
    }
	
	public function edit($id)
    {
		$info = DB::table('sys_area')
							->where('area_id', $id)
							->first();				
		$data['area_id'] 			= $info->area_id;
		$data['area_name'] 			= $info->area_name;		
		$data['area_code'] 			= $info->area_code;		
		$data['area_opening_date'] 	= $info->area_opening_date;		
		$data['status'] 			= $info->status;		
		return $data;
    }
	
	public function update(Request $request, $id)
    {
		$data = request()->except(['_token','_method']);	
		$data['updated_by']		  = Session::get('user_id');		
		$update['status']         = DB::table('sys_area')
            ->where('area_id', $id)
            ->update($data);
		echo json_encode($update);
    }
	

	public function all_data(Request $request)
    {       
		$columns = array( 
			0 =>'area_id', 
			1 =>'area_name',
			1 =>'area_code',
			2 =>'area_opening_date',
		);
        $totalData = Area::count();
        $totalFiltered = $totalData; 
        $limit 	= $request->input('length');
        $start 	= $request->input('start');
        $order 	= $columns[$request->input('order.0.column')];
        $dir 	= $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $infos = Area:: offset($start)
							->limit($limit)
							->orderBy($order,$dir)
							->get();
        }
        else{
            $search = $request->input('search.value'); 
            $infos 	=  Area::where('area_name','LIKE',"%{$search}%")
							->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
            $totalFiltered = Area::where('area_name','LIKE',"%{$search}%")
							->count();
        }

        $data = array();
        if(!empty($infos))
        {
            $i=1;
            foreach ($infos as $info)
            {
                $nestedData['sl'] 					= $i++;
                $nestedData['area_name'] 			= $info->area_name;
				$nestedData['area_code'] 			= $info->area_code;
                $nestedData['area_opening_date'] 	= $info->area_opening_date;
                
				if($info->status == 1)
				{
					$status = 'Active';
				}
				else{
					$status = 'Cancelled';
				}
                $nestedData['status'] 		= $status;      
				$nestedData['action'] 		= '<button class="btn btn-sm btn-primary btn-xs"  title="Edit" onclick="edit('.$info->area_id.')"><i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i></button>';
				
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
