<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\User_types;
use Session;
use Illuminate\Support\Facades\Redirect;


class ListController extends Controller
{

	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data = array();
		$data['colums'] 		= array("sl"=>"Sl", "utype_name"=>"User type Name", "status"=>"Status", "action"=>"Action"); 
		$data['heading'] 		= 'List';
		$data['Sub_heading'] 	= 'List Manager';
		$data['controller'] 	= 'list';
		$data['add_button'] 	= 'Add New';	
		$data['page_type'] 		= 1	;	
		return view('templates/list',$data);					
    }
	
	public function create()
	{
		$data = array();
		$data['heading'] 		= 'List';
		$data['Sub_heading'] 	= 'List Manager';
		$data['controller'] 	= 'list';
		$data['add_button'] 	= 'Add New';	
		$data['page_type'] 		= 2	;	
		return view('templates/form',$data);	
	}
	
	public function edit($id)
    {
        return $data = User_types::find($id);
    }

	public function all_data(Request $request)
    {       
		$columns = array( 
			0 =>'id', 
			1 =>'utype_name',
			2=> 'status',
		);
        $totalData = User_types::count();
        $totalFiltered = $totalData; 
        $limit 	= $request->input('length');
        $start 	= $request->input('start');
        $order 	= $columns[$request->input('order.0.column')];
        $dir 	= $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $infos = User_types::offset($start)
							->limit($limit)
							->orderBy($order,$dir)
							->get();
        }
        else{
            $search = $request->input('search.value'); 
            $infos 	=  User_types::where('utype_name','LIKE',"%{$search}%")
							->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
            $totalFiltered = User_types::where('utype_name','LIKE',"%{$search}%")
							->count();
        }

        $data = array();
        if(!empty($infos))
        {
            $i=1;
            foreach ($infos as $info)
            {
                $nestedData['sl'] 			= $i++;
                $nestedData['utype_name'] 	= $info->utype_name;
				if($info->status == 1)
				{
					$status = 'Active';
				}
				else{
					$status = 'Cancelled';
				}
                $nestedData['status'] 		= $status;      
				$nestedData['action'] 		= '<a class="btn btn-sm btn-success btn-xs" title="Edit" href="list/'.$info->id.'/edit"><i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i> Edit</a>';	
				
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
