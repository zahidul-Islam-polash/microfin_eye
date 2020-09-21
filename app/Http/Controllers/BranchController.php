<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Branch;
use Session;
use Illuminate\Support\Facades\Redirect;


class BranchController extends Controller
{

	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data = array();
		$data['colums'] 		= array("sl"=>"Sl", "branch_name"=>"Branch Name", "branch_code"=>"Branch Code","status"=>"Status", "action"=>"Action"); 
		$data['heading'] 		= 'Branch';
		$data['Sub_heading'] 	= 'Branch Manager';
		$data['controller'] 	= 'branch';
		$data['add_button'] 	= 'Add New';	
		$data['page_type'] 		= 1	;	
		return view('templates/list',$data);					
    }
	
	public function create()
	{
		$data = array();
		$data['heading'] 				= 'Branch';
		$data['Sub_heading'] 			= 'Branch Manager';
		$data['button'] 				= 'Save';	
		$data['page_type'] 				= 2	;	
		$data['action'] 				= 'branch';
		$data['method_control'] 		= ''; 			
		$data['branch_id'] 				= '';
		$data['branch_code'] 			= '';
		$data['branch_name'] 			= '';
		$data['branch_opening_date'] 	= '';
		$data['branch_closing_date'] 	= '';
		$data['branch_lat'] 			= '';
		$data['branch_lon'] 			= '';
		$data['status'] 				= 1;
		return view('settings/branch',$data);	
	}
	
	public function store(Request $request)
    {
        $data =array();
		$data = request()->except(['_token','_method']);
		$data['division_id']	= 1;
		$data['district_id']	= 1;
		$data['upazila_id']		= 1;
		$data['created_by']		= Session::get('user_id');;
		$status = Branch::insertGetId($data);
		return Redirect::to('/branch');
    }
	

	public function update(Request $request, $id)
    {
		$data =array();
		$data = request()->except(['_token','_method']);
		$data['division_id']	= 1;
		$data['district_id']	= 1;
		$data['upazila_id']		= 1;
		$data['updated_by']		= Session::get('user_id');;
		$status         		= DB::table('sys_branch')
									->where('branch_id', $id)
									->update($data);
		return Redirect::to('/branch');
    }
	public function edit($id)
    {
        $info = DB::table('sys_branch')
							->where('branch_id', $id)
							->first();				
		$data = array();
		$data['heading'] 				= 'Branch';
		$data['Sub_heading'] 			= 'Branch Manager';
		$data['button'] 				= 'Update';	
		$data['page_type'] 				= 2	;	
		$data['method_control'] 		= ''; 
		$data['action'] 				= "/branch/$id";
		$data['method_control'] 		= "<input type='hidden' name='_method' value='PUT' />"; 
		$data['branch_id'] 				= $info->branch_id;
		$data['branch_code'] 			= $info->branch_code;
		$data['branch_name'] 			= $info->branch_name;
		$data['branch_opening_date'] 	= $info->branch_opening_date;
		$data['branch_closing_date'] 	= $info->branch_closing_date;
		$data['branch_lat'] 			= $info->branch_lat;
		$data['branch_lon'] 			= $info->branch_lon;
		$data['status'] 				= $info->status;
		return view('settings/branch',$data);	
    }

	public function all_data(Request $request)
    {       
		//$segment = request()->segment(1);
		$segment = 'branch';
		$columns = array( 
			0 =>'branch_id', 
			1 =>'branch_name',
			1 =>'branch_code',
			2=> 'status',
		);
        $totalData = Branch::count();
        $totalFiltered = $totalData; 
        $limit 	= $request->input('length');
        $start 	= $request->input('start');
        $order 	= $columns[$request->input('order.0.column')];
        $dir 	= $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $infos = Branch::offset($start)
							->limit($limit)
							->orderBy($order,$dir)
							->get();
        }
        else{
            $search = $request->input('search.value'); 
            $infos 	=  Branch::where('branch_name','LIKE',"%{$search}%")
							->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
            $totalFiltered = Branch::where('branch_name','LIKE',"%{$search}%")
							->count();
        }

        $data = array();
        if(!empty($infos))
        {
            $i=1;
            foreach ($infos as $info)
            {
                $nestedData['sl'] 			= $i++;
                $nestedData['branch_name'] 	= $info->branch_name;
                $nestedData['branch_code'] 	= $info->branch_code;
				if($info->status == 1)
				{
					$status = 'Active';
				}
				else{
					$status = 'Cancelled';
				}
                $nestedData['status'] 		= $status;      
				$nestedData['action'] 		= '<a class="btn btn-sm btn-success btn-xs" title="Edit" href="'.$segment.'/'.$info->branch_id.'/edit"><i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i> Edit</a>';	
				
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
