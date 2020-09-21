<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Voucher_config;
use Session;
use Illuminate\Support\Facades\Redirect;


class Voucher_configController extends Controller
{

	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data = array();
		$data['colums'] 		= array("sl"=>"Sl", "is_auto_generated"=>"is_auto_generated", "pv_prefix"=>"pv_prefix", "status"=>"Status", "action"=>"Action"); 
		$data['heading'] 		= 'Voucher Config';
		$data['Sub_heading'] 	= 'Voucher Config Manager';
		$data['controller'] 	= 'voucher_config';
		$data['add_button'] 	= 'Add New';	
		$data['page_type'] 		= 1	;					
		return view('templates/list',$data);					
    }
	
	public function create()
	{
		$data = array();
		$data['heading'] 				= 'Voucher_config';
		$data['Sub_heading'] 			= 'Voucher_config Manager';
		$data['button'] 				= 'Save';	
		$data['page_type'] 				= 2	;	
		$data['action'] 				= 'voucher_config';
		$data['method_control'] 		= ''; 			
		$data['vc_id'] 				= '';
		$data['branch_code'] 			= '';
		$data['branch_name'] 			= '';
		$data['branch_opening_date'] 	= '';
		$data['branch_closing_date'] 	= '';
		$data['branch_lat'] 			= '';
		$data['branch_lon'] 			= '';
		$data['status'] 				= 1;
		return view('settings/voucher_config',$data);	
	}
	
	public function store(Request $request)
    {
        $data =array();
		$data = request()->except(['_token','_method']);
		$data['division_id']	= 1;
		$data['district_id']	= 1;
		$data['upazila_id']		= 1;
		$data['created_by']		= Session::get('user_id');;
		$status = Voucher_config::insertGetId($data);
		return Redirect::to('/voucher_config');
    }
	

	public function update(Request $request, $id)
    {
		$data =array();
		$data = request()->except(['_token','_method']);
		$data['division_id']	= 1;
		$data['district_id']	= 1;
		$data['upazila_id']		= 1;
		$data['updated_by']		= Session::get('user_id');;
		$status         		= DB::table('vc_id')
									->where('vc_id', $id)
									->update($data);
		return Redirect::to('/voucher_config');
    }
	public function edit($id)
    {
        $info = DB::table('vc_id')
							->where('vc_id', $id)
							->first();				
		$data = array();
		$data['heading'] 				= 'Voucher_config';
		$data['Sub_heading'] 			= 'Voucher_config Manager';
		$data['button'] 				= 'Update';	
		$data['page_type'] 				= 2	;	
		$data['method_control'] 		= ''; 
		$data['action'] 				= "/voucher_config/$id";
		$data['method_control'] 		= "<input type='hidden' name='_method' value='PUT' />"; 
		$data['vc_id'] 					= $info->vc_id;
		$data['is_auto_generated'] 		= $info->is_auto_generated;
		$data['pv_prefix'] 				= $info->pv_prefix;
		$data['rv_prefix'] 				= $info->rv_prefix;
		$data['jv_prefix'] 				= $info->jv_prefix;
		$data['ftv_prefix'] 			= $info->ftv_prefix;
		$data['segment_1'] 				= $info->segment_1;
		$data['segment_2'] 				= $info->segment_2;
		$data['segment_3'] 				= $info->segment_3;
		$data['segment_4'] 				= $info->segment_4;
		$data['auto_increment_length'] 	= $info->auto_increment_length;
		$data['code_separator'] 		= $info->code_separator;
		$data['status'] 				= $info->status;
		return view('settings/voucher_config',$data);	
    }

	public function all_data(Request $request)
    {       
		//$segment = request()->segment(1);
		$segment = 'voucher_config';
		$columns = array( 
			0 =>'vc_id', 
			1 =>'is_auto_generated',
			1 =>'pv_prefix',
			2=> 'status',
		);
        $totalData = Voucher_config::count();
        $totalFiltered = $totalData; 
        $limit 	= $request->input('length');
        $start 	= $request->input('start');
        $order 	= $columns[$request->input('order.0.column')];
        $dir 	= $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $infos = Voucher_config::offset($start)
							->limit($limit)
							->orderBy($order,$dir)
							->get();
        }
        else{
            $search = $request->input('search.value'); 
            $infos 	=  Voucher_config::where('is_auto_generated','LIKE',"%{$search}%")
							->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
            $totalFiltered = Voucher_config::where('is_auto_generated','LIKE',"%{$search}%")
							->count();
        }

        $data = array();
        if(!empty($infos))
        {
            $i=1;
            foreach ($infos as $info)
            {
                $nestedData['sl'] 					= $i++;
                $nestedData['is_auto_generated'] 	= $info->is_auto_generated;
                $nestedData['pv_prefix'] 			= $info->pv_prefix;
				if($info->status == 1)
				{
					$status = 'Active';
				}
				else{
					$status = 'Cancelled';
				}
                $nestedData['status'] 		= $status;      
				$nestedData['action'] 		= '<a class="btn btn-sm btn-success btn-xs" title="Edit" href="'.$segment.'/'.$info->vc_id.'/edit"><i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i> Edit</a>';	
				
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
