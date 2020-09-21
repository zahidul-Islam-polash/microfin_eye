<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Member_samity_transfer;
use Session;
use Illuminate\Support\Facades\Redirect;


class Member_samity_transferController  extends Controller
{

	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data = array();
		$data['colums'] 		= array("sl"=>"Sl", "member_id"=>"Member ID", "current_branch"=>"Current Branch", "new_samity"=>"New Samity", "new_member_code"=>"New Member Code", "transfer_date"=>"Transfer Date", "status"=>"Status", "action"=>"Action"); 
		$data['heading'] 		= 'Member Samity Transfer';
		$data['Sub_heading'] 	= 'Member Samity Transfer';
		$data['controller'] 	= 'Member_samity_transfer';
		$data['add_button'] 	= 'Add New';	
		$data['page_type'] 		= 1;
		$br_code = Session::get('branch_id');	
		$data['samities'] 		= DB::table('samity_samity')
									->where('branch_id', $br_code)
									->get();
		return view('member/member_samity_transfer',$data);					
    }
	
	
	public function store(Request $request)
    {
        $data =array();
		$data = request()->except(['_token']);
		$data['created_by']		= Session::get('user_id');
		$data['status'] = Member_samity_transfer::insertGetId($data);
		echo json_encode($data);
    }
	
	public function edit($id)
    {
		$info = DB::table('member_samity_transfer')
							->where('transfer_id', $id)
							->first();				
		$data['transfer_id'] 		= $info->transfer_id;
		$data['member_id'] 			= $info->member_id;
		$data['current_branch'] 	= $info->current_branch;
		$data['new_samity'] 		= $info->new_samity;
		$data['new_member_code'] 	= $info->new_member_code;
		$data['transfer_date'] 		= $info->transfer_date;
		$data['status'] 			= $info->status;		
		return $data;
    }
	
	public function update(Request $request, $id)
    {
		$data = request()->except(['_token','_method']);	
		$data['updated_by']		= Session::get('user_id');		
		$update['status']         = DB::table('member_samity_transfer')
            ->where('transfer_id', $id)
            ->update($data);
		echo json_encode($update);
    }
	

	public function all_data(Request $request)
    {       
		$columns = array( 
			0 =>'transfer_id', 
			1 =>'member_id',
			2 =>'current_branch',
			3 =>'new_samity',
			4 =>'new_member_code',
			5 =>'transfer_date',
		);
        $totalData = Member_samity_transfer::count();
        $totalFiltered = $totalData; 
        $limit 	= $request->input('length');
        $start 	= $request->input('start');
        $order 	= $columns[$request->input('order.0.column')];
        $dir 	= $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $infos = Member_samity_transfer:: offset($start)
							->limit($limit)
							->orderBy($order,$dir)
							->get();
        }
        else{
            $search = $request->input('search.value'); 
            $infos 	=  Member_samity_transfer::where('member_id','LIKE',"%{$search}%")
							->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
            $totalFiltered = Member_samity_transfer::where('member_id','LIKE',"%{$search}%")
							->count();
        }

        $data = array();
        if(!empty($infos))
        {
            $i=1;
            foreach ($infos as $info)
            {
                $nestedData['sl'] 				= $i++;
                $nestedData['member_id'] 		= $info->member_id;
                $nestedData['current_branch'] 	= $info->current_branch;
                $nestedData['new_samity'] 		= $info->new_samity;
                $nestedData['new_member_code'] 	= $info->new_member_code;
                $nestedData['transfer_date'] 	= $info->transfer_date;

				if($info->status == 1)
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Cancelled';
				}
                $nestedData['status'] 		= $status;      
				$nestedData['action'] 		= '<button class="btn btn-sm btn-primary btn-xs"  title="Edit" onclick="edit('.$info->transfer_id.')"><i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i></button>';
				
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
