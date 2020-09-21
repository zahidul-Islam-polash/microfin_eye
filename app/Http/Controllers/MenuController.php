<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Menu;
use Session;
use Illuminate\Support\Facades\Redirect;


class MenuController extends Controller
{

	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data = array();
		$data['colums'] 		= array("sl"=>"Sl", "menu_name"=>"menu Name", "menu_link"=>"Link", "menu_sl"=>"Serial",  "status"=>"Status", "action"=>"Action"); 
		$data['heading'] 		= 'Menu';
		$data['Sub_heading'] 	= 'Menu Manager';
		$data['controller'] 	= 'menu';
		$data['add_button'] 	= 'Add New';	
		$data['page_type'] 		= 1	;	
		return view('templates/list',$data);					
    }
	
		public function create()
	{
		$data = array();
		$data['heading'] 			= 'Menu';
		$data['Sub_heading'] 		= 'Menu Manager';
		$data['button'] 			= 'Save';	
		$data['page_type'] 			= 2	;	
		$data['action'] 			= 'menu';
		$data['method_control'] 	= ''; 
		//
		$data['menu_id'] 			= '';
		$data['menu_name'] 			= '';
		$data['nav_id'] 			= '';
		$data['style_css'] 			= '';
		$data['has_sub_menu'] 		= 1;
		$data['menu_link'] 			= '';
		$data['menu_sl'] 			= '';
		$data['status'] 			= 1;
		//
		$data['navs'] 				= DB::table('user_nav_menu')
										->where('status', 1)
										->get();
		return view('config/menu',$data);	
	}
	
	public function store(Request $request)
    {
        $data =array();
		$data = request()->except(['_token','_method']);
		$data['created_by']		= Session::get('user_id');;
		$status = Menu::insertGetId($data);
		return Redirect::to('/menu');
    }
	

	public function update(Request $request, $id)
    {
		$data =array();
		$data = request()->except(['_token','_method']);
		$data['updated_by']		= Session::get('user_id');;
		$status         		= DB::table('user_menu')
									->where('menu_id', $id)
									->update($data);
		return Redirect::to('/menu');
    }
	public function edit($id)
    {
        $info = DB::table('user_menu')
							->where('menu_id', $id)
							->first();				
		$data = array();
		$data['heading'] 				= 'Nav Menu';
		$data['Sub_heading'] 			= 'Nav Menu Manager';
		$data['button'] 				= 'Update';	
		$data['page_type'] 				= 2	;	
		$data['method_control'] 		= ''; 
		$data['action'] 				= "/menu/$id";
		$data['method_control'] 		= "<input type='hidden' name='_method' value='PUT' />"; 
		//
		$data['menu_id'] 			= $info->menu_id;
		$data['menu_name'] 			= $info->menu_name;
		$data['nav_id'] 			= $info->nav_id;
		$data['style_css'] 			= $info->style_css;
		$data['has_sub_menu'] 		= $info->has_sub_menu;
		$data['menu_link'] 			= $info->menu_link;
		$data['menu_sl'] 			= $info->menu_sl;
		$data['status'] 			= $info->status;
		$data['navs'] 				= DB::table('user_nav_menu')
										->where('status', 1)
										->get();
		return view('config/menu',$data);	
    }
	


	public function all_data(Request $request)
    {       
		$segment = 'menu';
		$columns = array( 
			0 =>'menu_id', 
			1 =>'menu_name',
			1 =>'menu_link',
			2=> 'status',
		);
        $totalData = Menu::count();
        $totalFiltered = $totalData; 
        $limit 	= $request->input('length');
        $start 	= $request->input('start');
        $order 	= $columns[$request->input('order.0.column')];
        $dir 	= $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $infos = Menu::offset($start)
							->limit($limit)
							->orderBy($order,$dir)
							->get();
        }
        else{
            $search = $request->input('search.value'); 
            $infos 	=  Menu::where('menu_name','LIKE',"%{$search}%")
							->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
            $totalFiltered = Menu::where('menu_name','LIKE',"%{$search}%")
							->count();
        }

        $data = array();
        if(!empty($infos))
        {
            $i=1;
            foreach ($infos as $info)
            {
                $nestedData['sl'] 			= $i++;
                $nestedData['menu_name'] 	= $info->menu_name;
                $nestedData['menu_link']		= $info->menu_link;
                $nestedData['menu_sl']		= $info->menu_sl;
				if($info->status == 1)
				{
					$status = 'Active';
				}
				else{
					$status = 'Cancelled';
				}
                $nestedData['status'] 		= $status;      
				$nestedData['action'] 		= '<a class="btn btn-sm btn-success btn-xs" title="Edit" href="'.$segment.'/'.$info->menu_id.'/edit"><i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i> Edit</a>';	
				
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
