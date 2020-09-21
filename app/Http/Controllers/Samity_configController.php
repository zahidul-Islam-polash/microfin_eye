<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Samity_config;
use Session;
use Illuminate\Support\Facades\Redirect;


class Samity_configController extends Controller
{

	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data = array();
		$data['colums'] 		= array("sl"=>"Sl", "max_member_per_samity"=>"Max Member", "is_show_loan_product"=>"Is Show Loan Product","status"=>"Status", "action"=>"Action"); 
		$data['heading'] 		= 'Samity Config';
		$data['Sub_heading'] 	= 'Samity Configuration';
		$data['controller'] 	= 'samity_config';
		$data['add_button'] 	= 'Add New';	
		$data['page_type'] 		= 1	;
		$data['zones'] 			= DB::table('sys_zone')
											->where('status', 1)
											->get();		
		return view('settings/samity_config',$data);					
    }
	
	public function store(Request $request)
    {
        $data =array();
		$data = request()->except(['_token']);
		$data['created_by']	= Session::get('user_id');
		$samity_config_id = Samity_config::insertGetId($data);
		echo json_encode(true);
    }
	
	public function edit($id)
    {
		$info = DB::table('samity_config')
							->where('samity_config_id', $id)
							->first();				
		$data['samity_config_id'] 				= $info->samity_config_id;
		$data['max_member_per_samity'] 			= $info->max_member_per_samity;		
		$data['is_show_loan_product'] 			= $info->is_show_loan_product;			
		$data['status'] 						= $info->status;		
		return $data;
    }
	
	public function update(Request $request, $id)
    {
		$data = request()->except(['_token','_method']);	
		$data['updated_by']		  = Session::get('user_id');		
		$update['status']         = DB::table('samity_config')
            ->where('samity_config_id', $id)
            ->update($data);
		echo json_encode($update);
    }
	

	public function all_data(Request $request)
    {       
		$columns = array( 
			0 =>'samity_config_id', 
			1 =>'max_member_per_samity',
			1 =>'is_show_loan_product',
			2 =>'status',
		);
        $totalData = Samity_config::count();
        $totalFiltered = $totalData; 
        $limit 	= $request->input('length');
        $start 	= $request->input('start');
        $order 	= $columns[$request->input('order.0.column')];
        $dir 	= $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $infos = Samity_config:: offset($start)
							->limit($limit)
							->orderBy($order,$dir)
							->get();
        }
        else{
            $search = $request->input('search.value'); 
            $infos 	=  Samity_config::where('max_member_per_samity','LIKE',"%{$search}%")
							->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
            $totalFiltered = Samity_config::where('max_member_per_samity','LIKE',"%{$search}%")
							->count();
        }

        $data = array();
        if(!empty($infos))
        {
            $i=1;
            foreach ($infos as $info)
            {
                $nestedData['sl'] 						= $i++;
                $nestedData['max_member_per_samity'] 	= $info->max_member_per_samity;
				$nestedData['is_show_loan_product'] 	= $info->is_show_loan_product;
				if($info->status == 1)
				{
					$status = 'Active';
				}
				else{
					$status = 'Cancelled';
				}
                $nestedData['status'] 		= $status;      
				$nestedData['action'] 		= '<button class="btn btn-sm btn-primary btn-xs"  title="Edit" onclick="edit('.$info->samity_config_id.')"><i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i></button>';
				
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
