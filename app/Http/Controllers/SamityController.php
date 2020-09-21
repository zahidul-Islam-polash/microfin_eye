<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Samity;
use Session;
use Illuminate\Support\Facades\Redirect;


class SamityController extends Controller
{

	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data = array();
		$data['colums'] 		= array("sl"=>"Sl", "samity_name"=>"samity Name", "samity_code"=>"Samity Code", "samity_type"=>'Samity Type',"status"=>"Status", "action"=>"Action"); 
		$data['heading'] 		= 'Samity';
		$data['Sub_heading'] 	= 'Samity Manager';
		$data['controller'] 	= 'samity';
		$data['add_button'] 	= 'Add New';	
		$data['page_type'] 		= 1	;	
		return view('templates/list',$data);					
    }
	
	public function create()
	{
		$data = array();
		$data['heading'] 				= 'Samity';
		$data['Sub_heading'] 			= 'Samity Manager';
		$data['button'] 				= 'Save';	
		$data['page_type'] 				= 2	;	
		$data['action'] 				= 'samity';
		$data['method_control'] 		= ''; 	
		//
		$data['branches'] 				= DB::table('sys_branch')
											->where('status', 1)
											->get();
		$data['samity_id'] 				= '';
		$data['branch_id'] 				= '';
		$data['samity_name'] 			= '';
		$data['samity_name_bn'] 		= '';
		$data['samity_code'] 			= '';
		$data['max_member'] 			= 30;
		$data['min_member'] 			= 5;
		$data['member_type'] 			= 1;
		$data['samity_type'] 			= 1;
		$data['samity_opening_date'] 	= '';
		$data['samity_closing_date'] 	= '';
		$data['samity_lat'] 			= '';
		$data['samity_lon'] 			= '';
		$data['status'] 				= 1;
		return view('settings/samity',$data);	
	}
	
	public function store(Request $request)
    {
        $data =array();
		$data = request()->except(['_token','_method']);
		$data['created_by']		= Session::get('user_id');
		$status = Samity::insertGetId($data);
		return Redirect::to('/samity');
    }
	
	public function update(Request $request, $id)
    {
		$data =array();
		$data = request()->except(['_token','_method']);
		$data['updated_by']		= Session::get('user_id');;
		$status         		= DB::table('samity_samity')
									->where('samity_id', $id)
									->update($data);
		return Redirect::to('/samity');	
    }
	
	public function edit($id)
    {
		$data = array();
		$data['heading'] 				= 'Samity';
		$data['Sub_heading'] 			= 'Samity Manager';
		$data['button'] 				= 'Update';	
		$data['page_type'] 				= 2	;	
		$data['action'] 				= "/samity/$id";
		$data['method_control'] 		= "<input type='hidden' name='_method' value='PUT' />"; 
		$info 							= DB::table('samity_samity')
											->where('samity_id', $id)
											->first();	
		//
		$data['branches'] 				= DB::table('sys_branch')
											->where('status', 1)
											->get();
		$data['samity_id'] 				= $info->samity_id;
		$data['branch_id'] 				= $info->branch_id;
		$data['samity_name'] 			= $info->samity_name;
		$data['samity_name_bn'] 		= $info->samity_name_bn;
		$data['samity_code'] 			= $info->samity_code;
		$data['max_member'] 			= $info->max_member;
		$data['min_member'] 			= $info->min_member;
		$data['member_type'] 			= $info->member_type;
		$data['samity_type'] 			= $info->samity_type;
		$data['samity_opening_date'] 	= $info->samity_opening_date;
		$data['samity_closing_date'] 	= $info->samity_closing_date;
		$data['samity_lat'] 			= $info->samity_lat;
		$data['samity_lon'] 			= $info->samity_lon;
		$data['status'] 				= $info->status;
		return view('settings/samity',$data);
    }

	public function all_data(Request $request)
    {       
		//$segment = request()->segment(1);
		$segment = 'samity';
		$columns = array( 
			0 =>'branch_id', 
			1 =>'samity_name',
			2 =>'samity_code',
			3 =>'samity_type',
			4=> 'status',
		);
        $totalData = Samity::count();
        $totalFiltered = $totalData; 
        $limit 	= $request->input('length');
        $start 	= $request->input('start');
        $order 	= $columns[$request->input('order.0.column')];
        $dir 	= $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $infos = Samity::offset($start)
							->limit($limit)
							->orderBy($order,$dir)
							->get();
        }
        else{
            $search = $request->input('search.value'); 
            $infos 	=  Samity::where('samity_name','LIKE',"%{$search}%")
							->orwhere('samity_code','LIKE',"%{$search}%")
							->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
            $totalFiltered = Samity::where('samity_name','LIKE',"%{$search}%")
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
                $nestedData['samity_code'] 	= $info->samity_code;
                $nestedData['samity_type'] 	= $info->samity_type;
				if($info->status == 1)
				{
					$status = 'Active';
				}
				else{
					$status = 'Cancelled';
				}
                $nestedData['status'] 		= $status;      
				$nestedData['action'] 		= '<a class="btn btn-sm btn-success btn-xs" title="Edit" href="'.$segment.'/'.$info->samity_id.'/edit"><i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i> Edit</a>';	
				
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
