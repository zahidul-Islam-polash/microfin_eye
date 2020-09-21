<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Models\Loan_config;
use Session;
use Illuminate\Support\Facades\Redirect;


class Loan_configController extends Controller
{

	public function __construct() 
	{
		$this->middleware("CheckUserSession");
	}
	
	public function index()
    {        	
		$data = array();
		$data['colums'] 		= array("sl"=>"Sl", "interest_cal_method"=>"Method", "additional_fee_label"=>"Aditional Label","status"=>"Status", "action"=>"Action"); 
		$data['heading'] 		= 'Lonan Config';
		$data['Sub_heading'] 	= 'Lonan Configuration';
		$data['controller'] 	= 'loan_config';
		$data['add_button'] 	= 'Add New';	
		$data['page_type'] 		= 1	;
		$data['zones'] 			= DB::table('sys_zone')
											->where('status', 1)
											->get();		
		return view('settings/loan_config',$data);					
    }
	
	public function store(Request $request)
    {
        $data =array();
		$data = request()->except(['_token']);
		$data['created_by']	= Session::get('user_id');
		$loan_config_id = Loan_config::insertGetId($data);
		echo json_encode(true);
    }
	
	public function edit($id)
    {
		$info = DB::table('loan_config')
							->where('loan_config_id', $id)
							->first();				
		$data['loan_config_id'] 				= $info->loan_config_id;
		$data['interest_cal_method'] 			= $info->interest_cal_method;		
		$data['is_another_method_allowed'] 		= $info->is_another_method_allowed;		
		$data['is_multiple_loan_allow_primary'] = $info->is_multiple_loan_allow_primary;		
		$data['additional_fee_label'] 			= $info->additional_fee_label;		
		$data['insurance_amount_label'] 		= $info->insurance_amount_label;		
		$data['is_rebate_allow_death'] 			= $info->is_rebate_allow_death;		
		$data['is_insurance_amount_edit'] 		= $info->is_insurance_amount_edit;		
		$data['is_multiple_one_time_loan_allow']= $info->is_multiple_one_time_loan_allow;		
		$data['is_first_payment_edit'] 			= $info->is_first_payment_edit;		
		$data['is_loan_cycle_edit'] 			= $info->is_loan_cycle_edit;		
		$data['disburse_amount_bank_payment'] 	= $info->disburse_amount_bank_payment;		
		$data['max_no_installment'] 			= $info->max_no_installment;		
		$data['eligible_int_cal_dfd_loan'] 		= $info->eligible_int_cal_dfd_loan;		
		$data['is_loan_form_fee_show'] 			= $info->is_loan_form_fee_show;		
		$data['max_age_member'] 				= $info->max_age_member;		
		$data['is_loan_security_option_on'] 	= $info->is_loan_security_option_on;		
		$data['is_mfs_transaction_allow'] 		= $info->is_mfs_transaction_allow;		
		$data['is_loan_audit_fee_editable'] 	= $info->is_loan_audit_fee_editable;		
		$data['status'] 						= $info->status;		
		return $data;
    }
	
	public function update(Request $request, $id)
    {
		$data = request()->except(['_token','_method']);	
		$data['updated_by']		  = Session::get('user_id');		
		$update['status']         = DB::table('loan_config')
            ->where('loan_config_id', $id)
            ->update($data);
		echo json_encode($update);
    }
	

	public function all_data(Request $request)
    {       
		$columns = array( 
			0 =>'loan_config_id', 
			1 =>'interest_cal_method',
			1 =>'additional_fee_label',
			2 =>'status',
		);
        $totalData = Loan_config::count();
        $totalFiltered = $totalData; 
        $limit 	= $request->input('length');
        $start 	= $request->input('start');
        $order 	= $columns[$request->input('order.0.column')];
        $dir 	= $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $infos = Loan_config:: offset($start)
							->limit($limit)
							->orderBy($order,$dir)
							->get();
        }
        else{
            $search = $request->input('search.value'); 
            $infos 	=  Loan_config::where('interest_cal_method','LIKE',"%{$search}%")
							->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();
            $totalFiltered = Loan_config::where('interest_cal_method','LIKE',"%{$search}%")
							->count();
        }

        $data = array();
        if(!empty($infos))
        {
            $i=1;
            foreach ($infos as $info)
            {
                $nestedData['sl'] 						= $i++;
                $nestedData['interest_cal_method'] 		= $info->interest_cal_method;
				$nestedData['additional_fee_label'] 	= $info->additional_fee_label;
				if($info->status == 1)
				{
					$status = 'Active';
				}
				else{
					$status = 'Cancelled';
				}
                $nestedData['status'] 		= $status;      
				$nestedData['action'] 		= '<button class="btn btn-sm btn-primary btn-xs"  title="Edit" onclick="edit('.$info->loan_config_id.')"><i class="fas fa-pencil-alt fa-fw" aria-hidden="true"></i></button>';
				
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
