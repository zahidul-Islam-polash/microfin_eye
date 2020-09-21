<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Member_closing;
use Session;
use Illuminate\Support\Facades\Redirect;


class Member_closingController  extends Controller
{

	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data = array();
		$data['colums'] 		= array("sl"=>"Sl", "member_id"=>"Member ID", "closing_date"=>"Closing Date", "note"=>"Note", "status"=>"Status", "action"=>"Action"); 
		$data['heading'] 		= 'Member Closing';
		$data['Sub_heading'] 	= 'Member Closing';
		$data['controller'] 	= 'Member_closing';
		$data['add_button'] 	= 'Add New';	
		$data['page_type'] 		= 1	;			
		return view('member/member_closing',$data);					
    }
	
	public function store(Request $request)
    {
        $data =array();
		$data = request()->except(['_token']);
		$data['created_by']		= Session::get('user_id');
		$data['status'] = Member_closing::insertGetId($data);
		echo json_encode($data);
    }
	
	public function edit($id)
    {
		$info = DB::table('member_closing')
							->where('closing_id', $id)
							->first();				
		$data['closing_id'] 	= $info->closing_id;
		$data['member_id'] 		= $info->member_id;
		$data['closing_date'] 	= $info->closing_date;
		$data['note'] 			= $info->note;
		$data['status'] 		= $info->status;		
		return $data;
    }
	
	public function update(Request $request, $id)
    {
		$data = request()->except(['_token','_method']);	
		$data['updated_by']		= Session::get('user_id');		
		$update['status']         = DB::table('member_closing')
            ->where('closing_id', $id)
            ->update($data);
		echo json_encode($update);
    }
	

	public function all_data(Request $request)
    {       
		$columns = array( 
			0 =>'closing_id', 
			1 =>'member_id',
			2 =>'closing_date',
			3 =>'note',
		);
        $totalData = Member_closing::count();
        $totalFiltered = $totalData; 
        $limit 	= $request->input('length');
        $start 	= $request->input('start');
        $order 	= $columns[$request->input('order.0.column')];
        $dir 	= $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $infos = Member_closing:: offset($start)
							->limit($limit)
							->orderBy($order,$dir)
							->get();
        }
        else{
            $search = $request->input('search.value'); 
            $infos 	=  Member_closing::where('member_id','LIKE',"%{$search}%")
							->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
            $totalFiltered = Member_closing::where('member_id','LIKE',"%{$search}%")
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
                $nestedData['closing_date'] 	= $info->closing_date;
                $nestedData['note'] 			= $info->note;
                
				if($info->status == 1)
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Cancelled';
				}
                $nestedData['status'] 		= $status;      
				$nestedData['action'] 		= '<button class="btn btn-sm btn-primary btn-xs"  title="Edit" onclick="edit('.$info->closing_id.')"><i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i></button>';
				
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
