<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Members;
use Session;
use Illuminate\Support\Facades\Redirect;


class MembersController extends Controller
{

	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()  
    {        	
		$data = array();
		$data['colums'] 		= array("sl"=>"Sl", "member_code"=>"Member Code", "member_name"=>"Member Name", "member_contact"=>"Contact", "member_admission_date"=>"Admission date ","member_photo"=>"Phoro",  "status"=>"Status", "action"=>"Action"); 
		$data['heading'] 		= 'Members';
		$data['Sub_heading'] 	= 'All Members List';
		$data['controller'] 	= 'members';
		$data['add_button'] 	= 'Add New Member';	
		$data['page_type'] 		= 1	;
		$data['samities']  		= DB::table('samity_samity')
									->where('branch_id', Session::get('branch_id'))
									->get();			
		return view('templates/list',$data);					
    }
	
	public function create()
	{
		$data = array();
		$data['heading'] 				= 'Members';
		$data['Sub_heading'] 			= 'Member Manager';
		$data['button'] 				= 'Save';	
		$data['page_type'] 				= 2	;	
		$data['action'] 				= 'members';
		$data['method_control'] 		= ''; 
		//
		$data['member_id'] 				= '';
		$data['member_code'] 			= '';
		$data['member_name'] 			= '';
		$data['member_dob'] 			= date('Y-m-d');
		$data['member_gender'] 			= 2;
		$data['member_contact'] 		= '';
		$data['member_nid'] 			= '';
		$data['member_contact'] 		= '';
		$data['member_photo'] 			= '';
		$data['member_admission_date'] 	= date('Y-m-d');
		$data['member_samity_id'] 		= '';
		$data['member_status'] 			= 1;
		return view('member/members',$data);	
	}
	
	
	public function store(Request $request)
    {
        $data =array();
		$data 					= request()->except(['_token','_method']);
		$data['member_br_id']	= Session::get('branch_id');
		$data['created_by']		= Session::get('user_id');
		$data['status'] 	= Members::insertGetId($data);
		echo json_encode($save_status);
    }
	

	public function update(Request $request, $id)
    {
		$data =array();
		$data = request()->except(['_token','_method']);
		$data['updated_by']		= Session::get('user_id');;
		$data['status']  = DB::table('members_info')
									->where('member_id', $id)
									->update($data);
		echo json_encode($save_status);
    }
	
	public function edit($id)
    {
        $info = DB::table('members_info')
							->where('member_id', $id)
							->first();				
		$data = array();
		$data['heading'] 				= 'Members';
		$data['Sub_heading'] 			= 'Member Manager';
		$data['button'] 				= 'Update';	
		$data['page_type'] 				= 2	;	
		$data['method_control'] 		= ''; 
		$data['action'] 				= "/members/$id";
		$data['method_control'] 		= "<input type='hidden' name='_method' value='PUT' />"; 
		//
		$data['member_id'] 				= $info->member_id;
		$data['member_code'] 			= $info->member_code;
		$data['member_name'] 			= $info->member_name;
		$data['member_dob'] 			= $info->member_dob;
		$data['member_gender'] 			= $info->member_gender;
		$data['member_contact'] 		= $info->member_contact;
		$data['member_nid'] 			= $info->member_nid;
		$data['member_photo'] 			= $info->member_photo;
		$data['member_admission_date'] 	= $info->member_admission_date;
		$data['member_samity_id'] 		= $info->member_samity_id;
		$data['member_status'] 			= $info->member_status;
		return view('member/members',$data);	
    }
	


	public function all_data(Request $request)
    {       
		$segment = 'members';
		$columns = array( 
			0 =>'member_code', 
			1 =>'member_name',
			1 =>'member_contact',
			2 =>'member_admission_date',
			3=> 'member_photo',
			4=> 'member_status',
		);
		
        $totalData = Members::count();
        $totalFiltered = $totalData; 
        $limit 	= $request->input('length');
        $start 	= $request->input('start');
        $order 	= $columns[$request->input('order.0.column')];
        $dir 	= $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $infos = Members::offset($start)
							->limit($limit)
							->orderBy($order,$dir)
							->get();
        }
        else{
            $search = $request->input('search.value'); 
            $infos 	=  Members::where('member_code','LIKE',"%{$search}%")
							->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
            $totalFiltered = Members::where('member_code','LIKE',"%{$search}%")
							->count();
        }

        $data = array();
        if(!empty($infos))
        {
            $i=1;
            foreach ($infos as $info)
            {
                $nestedData['sl'] 						= $i++;
                $nestedData['member_code'] 				= $info->member_code;
                $nestedData['member_name']				= $info->member_name;
                $nestedData['member_contact']			= $info->member_contact;
                $nestedData['member_admission_date']	= $info->member_admission_date;
                $nestedData['member_photo']				= $info->member_photo;
				if($info->member_status == 1)
				{
					$status = 'Active';
				}
				else{
					$status = 'Cancelled';
				}
                $nestedData['status'] 		= $status;      
				$nestedData['action'] 		= '<a class="btn btn-sm btn-success btn-xs" title="Edit" href="'.$segment.'/'.$info->member_id.'/edit"><i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i> Edit</a>';	
				
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
