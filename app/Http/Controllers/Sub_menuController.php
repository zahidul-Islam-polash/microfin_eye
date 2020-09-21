<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Sub_menu;
use Session;
use Illuminate\Support\Facades\Redirect;


class Sub_menuController extends Controller
{

	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data = array();
		$data['colums'] 		= array("sl"=>"Sl", "sub_menu_name"=>"Sub Menu Name", "sub_menu_link"=>"Link", "sub_menu_sl"=>"Serial",  "status"=>"Status", "action"=>"Action"); 
		$data['heading'] 		= 'Sub Menu';
		$data['Sub_heading'] 	= 'Sub Menu Manager';
		$data['controller'] 	= 'sub_menu';
		$data['add_button'] 	= 'Add New';	
		$data['page_type'] 		= 1	;	
		return view('templates/list',$data);					
    }
	
	public function create()
	{
		$data = array();
		$data['heading'] 			= 'Sub Menu';
		$data['Sub_heading'] 		= 'Sub Menu Manager';
		$data['button'] 			= 'Save';	
		$data['page_type'] 			= 2	;	
		$data['action'] 			= 'sub_menu';
		$data['method_control'] 	= ''; 
		//
		$data['sub_menu_id'] 		= '';
		$data['sub_menu_name'] 		= '';
		$data['menu_id'] 			= '';
		$data['style_css'] 			= '';
		$data['sub_menu_link'] 		= '';
		$data['sub_menu_sl'] 		= '';
		$data['status'] 			= 1;
		//
		$data['menus'] 				= DB::table('user_menu')
										->where('status', 1)
										->get();
		return view('config/sub_menu',$data);	
	}
	
	public function store(Request $request)
    {
        $data =array();
		$data = request()->except(['_token','_method']);
		$data['created_by']		= Session::get('user_id');;
		$status = Sub_menu::insertGetId($data);
		return Redirect::to('/sub_menu');
    }
	

	public function update(Request $request, $id)
    {
		$data =array();
		$data = request()->except(['_token','_method']);
		$data['updated_by']		= Session::get('user_id');;
		$status         		= DB::table('user_sub_menu')
									->where('sub_menu_id', $id)
									->update($data);
		return Redirect::to('/sub_menu');
    }
	public function edit($id)
    {
        $info = DB::table('user_sub_menu')
							->where('sub_menu_id', $id)
							->first();				
		$data = array();
		$data['heading'] 				= 'Nav Sub_menu';
		$data['Sub_heading'] 			= 'Nav Sub_menu Manager';
		$data['button'] 				= 'Update';	
		$data['page_type'] 				= 2	;	
		$data['method_control'] 		= ''; 
		$data['action'] 				= "/sub_menu/$id";
		$data['method_control'] 		= "<input type='hidden' name='_method' value='PUT' />"; 
		//
		$data['sub_menu_id'] 			= $info->sub_menu_id;
		$data['sub_menu_name'] 			= $info->sub_menu_name;
		$data['menu_id'] 				= $info->menu_id;
		$data['style_css'] 				= $info->style_css;
		$data['sub_menu_link'] 			= $info->sub_menu_link;
		$data['sub_menu_sl'] 			= $info->sub_menu_sl;
		$data['status'] 				= $info->status;
		$data['menus'] 					= DB::table('user_menu')
											->where('status', 1)
											->get();
		return view('config/sub_menu',$data);	
    }
	


	public function all_data(Request $request)
    {       
		$segment = 'sub_menu';
		$columns = array( 
			0 =>'sub_menu_id', 
			1 =>'sub_menu_name',
			1 =>'sub_menu_link',
			2=> 'status',
		);
        $totalData = Sub_menu::count();
        $totalFiltered = $totalData; 
        $limit 	= $request->input('length');
        $start 	= $request->input('start');
        $order 	= $columns[$request->input('order.0.column')];
        $dir 	= $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $infos = Sub_menu::offset($start)
							->limit($limit)
							->orderBy($order,$dir)
							->get();
        }
        else{
            $search = $request->input('search.value'); 
            $infos 	=  Sub_menu::where('sub_menu_name','LIKE',"%{$search}%")
							->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
            $totalFiltered = Sub_menu::where('sub_menu_name','LIKE',"%{$search}%")
							->count();
        }

        $data = array();
        if(!empty($infos))
        {
            $i=1;
            foreach ($infos as $info)
            {
                $nestedData['sl'] 			= $i++;
                $nestedData['sub_menu_name'] 	= $info->sub_menu_name;
                $nestedData['sub_menu_link']	= $info->sub_menu_link;
                $nestedData['sub_menu_sl']		= $info->sub_menu_sl;
				if($info->status == 1)
				{
					$status = 'Active';
				}
				else{
					$status = 'Cancelled';
				}
                $nestedData['status'] 		= $status;      
				$nestedData['action'] 		= '<a class="btn btn-sm btn-success btn-xs" title="Edit" href="'.$segment.'/'.$info->sub_menu_id.'/edit"><i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i> Edit</a>';	
				
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
