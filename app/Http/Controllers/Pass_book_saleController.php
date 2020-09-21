<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Member_passbook_sale;
use Session;
use Illuminate\Support\Facades\Redirect;


class Pass_book_saleController  extends Controller
{

	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data = array();
		$data['colums'] 		= array("sl"=>"Sl", "member_id"=>"Member ID", "sale_date"=>"Sale Date", "passbook_no"=>"Passbook No", "amount"=>"Amount",  "status"=>"Status", "action"=>"Action"); 
		$data['heading'] 		= 'Member Passbook Sale';
		$data['Sub_heading'] 	= 'Member Passbook Sale';
		$data['controller'] 	= 'Pass_book_saleController';
		$data['add_button'] 	= 'Add New';	
		$data['page_type'] 		= 1	;						
		return view('member/member_pass_book_sale',$data);					
    }
	
	public function store(Request $request)
    {
        $data =array();
		$data = request()->except(['_token']);
		$data['created_by']		= Session::get('user_id');
		$data['status'] = Member_passbook_sale::insertGetId($data);
		echo json_encode($data);
    }
	
	public function edit($id)
    {
		$info = DB::table('member_passbook_sale')
							->where('sale_id', $id)
							->first();				
		$data['sale_id'] 		= $info->sale_id;
		$data['member_id'] 		= $info->member_id;
		$data['sale_date'] 		= $info->sale_date;
		$data['passbook_no'] 	= $info->passbook_no;
		$data['amount'] 		= $info->amount;
		$data['status'] 		= $info->status;		
		return $data;
    }
	
	public function update(Request $request, $id)
    {
		$data = request()->except(['_token','_method']);	
		$data['updated_by']		= Session::get('user_id');		
		$update['status']         = DB::table('member_passbook_sale')
            ->where('sale_id', $id)
            ->update($data);
		echo json_encode($update);
    }
	

	public function all_data(Request $request)
    {       
		$columns = array( 
			0 =>'sale_id', 
			1 =>'member_id',
			2 =>'sale_date',
			3 =>'passbook_no',
			4 =>'amount',
		);
        $totalData = Member_passbook_sale::count();
        $totalFiltered = $totalData; 
        $limit 	= $request->input('length');
        $start 	= $request->input('start');
        $order 	= $columns[$request->input('order.0.column')];
        $dir 	= $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $infos = Member_passbook_sale:: offset($start)
							->limit($limit)
							->orderBy($order,$dir)
							->get();
        }
        else{
            $search = $request->input('search.value'); 
            $infos 	=  Member_passbook_sale::where('member_id','LIKE',"%{$search}%")
							->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
            $totalFiltered = Member_passbook_sale::where('member_id','LIKE',"%{$search}%")
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
                $nestedData['sale_date'] 		= $info->sale_date;
                $nestedData['passbook_no'] 		= $info->passbook_no;
                $nestedData['amount'] 			= $info->amount;

				if($info->status == 1)
				{
					$status = 'Active';
				}
				else
				{
					$status = 'Cancelled';
				}
                $nestedData['status'] 		= $status;      
				$nestedData['action'] 		= '<button class="btn btn-sm btn-primary btn-xs"  title="Edit" onclick="edit('.$info->sale_id.')"><i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i></button>';
				
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
