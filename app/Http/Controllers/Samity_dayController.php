<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Samity_day;
use Session;
use Illuminate\Support\Facades\Redirect;


class Samity_dayController extends Controller
{

	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data = array();
		$data['colums'] 		= array("sl"=>"Sl", "samity_name"=>"Samity", "day"=>"Samity day", "from_date"=>"Active From",  "status"=>"Status", "action"=>"Action"); 
		$data['heading'] 		= 'Samity Day';
		$data['Sub_heading'] 	= 'Samity Day Manager';
		$data['controller'] 	= 'samity Day';
		$data['add_button'] 	= 'Add New';	
		$data['page_type'] 		= 1	;		
		$data['samities'] 		= DB::table('samity_samity')
									->where('status', 1)
									->get();	
		$data['days'] 			= DB::table('samity_working_day')
									->where('status', 1)
									->get();		
		return view('settings/samity_day',$data);					
    }
	
	public function store(Request $request)
    {
        $data =array();
		$data = request()->except(['_token']);
		$data['created_by']		= Session::get('user_id');
		$status = Samity_day::insertGetId($data);
		echo json_encode($data);
    }
	
	public function edit($id)
    {
		$info = DB::table('samity_day')
							->where('samity_day_id', $id)
							->first();				
		$data['samity_day_id'] 	= $info->samity_day_id;
		$data['samity_id'] 		= $info->samity_id;		
		$data['day_id'] 		= $info->day_id;		
		$data['from_date'] 		= $info->from_date;		
		$data['to_date'] 		= $info->to_date;		
		$data['status'] 		= $info->status;		
		return $data;
    }
	
	public function update(Request $request, $id)
    {
		$data = request()->except(['_token','_method']);	
		$data['updated_by']		= Session::get('user_id');		
		$update['status']         = DB::table('samity_day')
            ->where('samity_day_id', $id)
            ->update($data);
		echo json_encode($update);
    }
	

	public function all_data(Request $request)
    {       
		$columns = array( 
			0 =>'samity_day_id', 
			1 =>'samity_id',
			2 =>'day_id',
			3 =>'from_date',
			4=> 'status',
		);
        $totalData = Samity_day::count();
        $totalFiltered = $totalData; 
        $limit 	= $request->input('length');
        $start 	= $request->input('start');
        $order 	= $columns[$request->input('order.0.column')];
        $dir 	= $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $infos = Samity_day::join('samity_samity', 'samity_samity.samity_id', '=', 'samity_day.samity_day_id' )
							->leftjoin('samity_working_day', 'samity_day.day_id', '=', 'samity_working_day.working_day_id' )
							->offset($start)
							->limit($limit)
							->orderBy($order,$dir)
							->get();
        }
        else{
            $search = $request->input('search.value'); 
            $infos 	=  Samity_day::join('samity_samity', 'samity_samity.samity_id', '=', 'samity_day.samity_day_id' )
							->leftjoin('samity_working_day', 'samity_day.day_id', '=', 'samity_working_day.working_day_id' )
							->where('samity_name','LIKE',"%{$search}%")
							->orwhere('samity_code','LIKE',"%{$search}%")
							->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
            $totalFiltered = Samity_day::where('samity_name','LIKE',"%{$search}%")
							->orwhere('samity_code','LIKE',"%{$search}%")
							->count();
        }

        $data = array();
        if(!empty($infos))
        {
            $i=1;
            foreach ($infos as $info)
            {
                $nestedData['sl'] 			= $i++;
                $nestedData['samity_name'] 	= $info->samity_name;
                $nestedData['day'] 			= $info->working_day_name;
                $nestedData['from_date'] 	= $info->from_date;
				if($info->status == 1)
				{
					$status = 'Active';
				}
				else{
					$status = 'Cancelled';
				}
                $nestedData['status'] 		= $status;      
				$nestedData['action'] 		= '<button class="btn btn-sm btn-primary btn-xs"  title="Edit" onclick="edit('.$info->samity_day_id.')"><i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i></button>';
				
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
