<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Nav_menu;
use Session;
use Illuminate\Support\Facades\Redirect;


class Nav_menuController extends Controller
{

	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data = array();
		$data['colums'] 		= array("sl"=>"Sl", "nav_name"=>"Nav Name", "nav_link"=>"Link", "nav_sl"=>"Serial",  "status"=>"Status", "action"=>"Action"); 
		$data['heading'] 		= 'Nav Menu';
		$data['Sub_heading'] 	= 'Nav Menu Manager';
		$data['controller'] 	= 'nav_menu';
		$data['add_button'] 	= 'Add New';	
		$data['page_type'] 		= 1	;	
		return view('templates/list',$data);					
    }
	
		public function create()
	{
		$data = array();
		$data['heading'] 			= 'Nav_menu';
		$data['Sub_heading'] 		= 'Nav Menu Manager';
		$data['button'] 			= 'Save';	
		$data['page_type'] 			= 2	;	
		$data['action'] 			= 'nav_menu';
		$data['method_control'] 	= ''; 
		//
		$data['nav_id'] 			= '';
		$data['nav_name'] 			= '';
		$data['style_class'] 		= 'fa fa-th-large';
		$data['has_menu'] 			= 1;
		$data['nav_link'] 			= '';
		$data['nav_sl'] 			= '';
		$data['status'] 			= 1;
		return view('config/nav_menu',$data);	
	}
	
	public function store(Request $request)
    {
        $data =array();
		$data = request()->except(['_token','_method']);
		$data['created_by']		= Session::get('user_id');;
		$status = Nav_menu::insertGetId($data);
		return Redirect::to('/nav_menu');
    }
	

	public function update(Request $request, $id)
    {
		$data =array();
		$data = request()->except(['_token','_method']);
		$data['updated_by']		= Session::get('user_id');;
		$status         		= DB::table('user_nav_menu')
									->where('nav_id', $id)
									->update($data);
		return Redirect::to('/nav_menu');
    }
	public function edit($id)
    {
        $info = DB::table('user_nav_menu')
							->where('nav_id', $id)
							->first();				
		$data = array();
		$data['heading'] 				= 'Nav Menu';
		$data['Sub_heading'] 			= 'Nav Menu Manager';
		$data['button'] 				= 'Update';	
		$data['page_type'] 				= 2	;	
		$data['method_control'] 		= ''; 
		$data['action'] 				= "/nav_menu/$id";
		$data['method_control'] 		= "<input type='hidden' name='_method' value='PUT' />"; 
		//
		$data['nav_id'] 			= $info->nav_id;
		$data['nav_name'] 			= $info->nav_name;
		$data['style_class'] 		= $info->style_class;
		$data['has_menu'] 			= $info->has_menu;
		$data['nav_link'] 			= $info->nav_link;
		$data['nav_sl'] 			= $info->nav_sl;
		$data['status'] 			= $info->status;
		return view('config/nav_menu',$data);	
    }
	


	public function all_data(Request $request)
    {       
		$segment = 'nav_menu';
		$columns = array( 
			0 =>'nav_id', 
			1 =>'nav_name',
			1 =>'nav_link',
			2 =>'nav_sl',
			3=> 'status',
		);
        $totalData = Nav_menu::count();
        $totalFiltered = $totalData; 
        $limit 	= $request->input('length');
        $start 	= $request->input('start');
        $order 	= $columns[$request->input('order.0.column')];
        $dir 	= $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $infos = Nav_menu::offset($start)
							->limit($limit)
							->orderBy($order,$dir)
							->get();
        }
        else{
            $search = $request->input('search.value'); 
            $infos 	=  Nav_menu::where('nav_name','LIKE',"%{$search}%")
							->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
            $totalFiltered = Nav_menu::where('nav_name','LIKE',"%{$search}%")
							->count();
        }

        $data = array();
        if(!empty($infos))
        {
            $i=1;
            foreach ($infos as $info)
            {
                $nestedData['sl'] 			= $i++;
                $nestedData['nav_name'] 	= $info->nav_name;
                $nestedData['nav_link']		= $info->nav_link;
                $nestedData['nav_sl']		= $info->nav_sl;
				if($info->status == 1)
				{
					$status = 'Active';
				}
				else{
					$status = 'Cancelled';
				}
                $nestedData['status'] 		= $status;      
				$nestedData['action'] 		= '<a class="btn btn-sm btn-success btn-xs" title="Edit" href="'.$segment.'/'.$info->nav_id.'/edit"><i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i> Edit</a>';	
				
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
