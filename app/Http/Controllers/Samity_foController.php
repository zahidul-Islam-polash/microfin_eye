<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Samity_fo;
use Session;
use Illuminate\Support\Facades\Redirect;


class Samity_foController extends Controller
{

	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data = array();
		$data['colums'] 		= array("sl"=>"Sl", "samity_id"=>"Samity", "fo_id"=>"Field Officer id", "from_date"=>'From Date',"status"=>"Status", "action"=>"Action"); 
		$data['heading'] 		= 'Samity FO';
		$data['Sub_heading'] 	= 'Samity FO Manager';
		$data['controller'] 	= 'samity_fo';
		$data['add_button'] 	= 'Add New';	
		$data['page_type'] 		= 1	;	
		return view('templates/list',$data);					
    }
	
	public function create()
	{
		$data = array();
		$data['heading'] 				= 'Samity FO';
		$data['Sub_heading'] 			= 'Samity FO Manager';
		$data['button'] 				= 'Save';	
		$data['page_type'] 				= 2	;	
		$data['action'] 				= 'samity_fo';
		$data['method_control'] 		= ''; 	
		//
		$data['samities'] 				= DB::table('samity_samity')
											->where('status', 1)
											->get();
		$data['all_fo'] 				=  DB::table('employee')
											->where('hr_br_id', 1)
											->get();
											 array('Jalal'=>10,'Kamal'=>10);
		$data['samity_fo_id'] 			= '';
		$data['samity_id'] 				= '';
		$data['fo_id'] 					= '';
		$data['from_date'] 				= '';
		$data['to_date'] 				= '';
		$data['status'] 				= 1;
		return view('settings/samity_fo',$data);	
	}
	
	public function store(Request $request)
    {
        $data =array();
		$data = request()->except(['_token','_method']);
		$data['created_by']		= Session::get('user_id');;
		$status = Samity_fo::insertGetId($data);
		return Redirect::to('/samity_fo');
    }
	
	public function update(Request $request, $id)
    {
		$data =array();
		$data = request()->except(['_token','_method']);
		$data['updated_by']		= Session::get('user_id');;
		$status         		= DB::table('samity_fo')
									->where('samity_fo_id', $id)
									->update($data);
		return Redirect::to('/samity_fo');	
    }
	
	public function edit($id)
    {
		$data = array();
		$data['heading'] 				= 'Samity FO';
		$data['Sub_heading'] 			= 'Samity FO Manager';
		$data['button'] 				= 'Update';	
		$data['page_type'] 				= 2	;	
		$data['action'] 				= "/samity_fo/$id";
		$data['method_control'] 		= "<input type='hidden' name='_method' value='PUT' />"; 
		$info 							= DB::table('samity_fo')
											->where('samity_fo_id', $id)
											->first();	
		//
		$data['samities'] 				= DB::table('samity_samity')
											->where('status', 1)
											->get();
		$data['all_fo'] 				=  DB::table('employee')
											->where('hr_br_id', 1)
											->get();
											 array('Jalal'=>10,'Kamal'=>10);
		$data['samity_fo_id'] 			= $info->samity_fo_id;
		$data['samity_id'] 				= $info->samity_id;
		$data['fo_id'] 					= $info->fo_id;
		$data['from_date'] 				= $info->from_date;
		$data['to_date'] 				= $info->to_date;
		$data['status'] 				= $info->status;
		return view('settings/samity_fo',$data);
    }

	public function all_data(Request $request)
    {       
		//$segment = request()->segment(1);
		$segment = 'Samity_fo';
		$columns = array( 
			0 =>'samity_fo_id', 
			1 =>'samity_id',
			2 =>'fo_id',
			3 =>'from_date',
			4 =>'to_date',
			5=> 'status',
		);
        $totalData = Samity_fo::count();
        $totalFiltered = $totalData; 
        $limit 	= $request->input('length');
        $start 	= $request->input('start');
        $order 	= $columns[$request->input('order.0.column')];
        $dir 	= $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $infos = Samity_fo::join('samity_samity', 'samity_samity.samity_id', '=', 'samity_fo.samity_id' )
							->offset($start)
							->limit($limit)
							->orderBy($order,$dir)
							->get();
        }
        else{
            $search = $request->input('search.value'); 
            $infos 	=  Samity_fo::where('samity_name','LIKE',"%{$search}%")
							->orwhere('samity_code','LIKE',"%{$search}%")
							->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
            $totalFiltered = Samity_fo::where('samity_name','LIKE',"%{$search}%")
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
                $nestedData['samity_id'] 	= $info->samity_name_bn.' ( '. $info->samity_code .' )';
                $nestedData['fo_id'] 		= $info->fo_id;
                $nestedData['from_date'] 	= $info->from_date;
				if($info->status == 1)
				{
					$status = 'Active';
				}
				else{
					$status = 'Cancelled';
				}
                $nestedData['status'] 		= $status;      
				$nestedData['action'] 		= '<a class="btn btn-sm btn-success btn-xs" title="Edit" href="'.$segment.'/'.$info->samity_fo_id.'/edit"><i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i> Edit</a>';	
				
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
