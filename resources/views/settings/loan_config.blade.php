	@extends('master')
	@section('main_content')
	
		
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb float-xl-right">
				<li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
				<li class="breadcrumb-item"><a href="javascript:;">Page Options</a></li>
				<li class="breadcrumb-item active">Page with Top Menu</li>
			</ol>
			<!-- end breadcrumb -->
			
			<!-- begin page-header -->
			<h1 class="page-header">Manage {{ $heading }} <small>{{ $Sub_heading }} </small></h1>
			<!-- end page-header -->
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<div class="panel-title">
						<a class="btn btn-xs btn-icon btn-circle btn-success" onclick="reload_table();"><i class="fa fa-redo"></i></a></td>
					</div>
					<div class="panel-heading-btn">
						<button onclick="add();" class="btn btn-sm btn-danger"> <i class="fa fa-plus"></i> {{ $add_button }}</button> 
					</div>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				
				<div class="panel-body">
					<table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
						<thead>							
							<tr>
							<?php $i = 0; foreach($colums as $key => $colum) { ?>
								<?php if($key == 'action') { $orderable = "false"; } else { $orderable = "true"; }?>
								<th data-orderable="<?php echo $orderable; ?>"><?php echo $colum; ?></th>
							<?php } ?>
							</tr>						
						</thead>
						<tbody>
	
						</tbody>
					</table>
				</div>
				<!-- end panel-body -->
			</div>
			<!-- end panel -->
			
		</div>
		<!-- end #content -->


	<script>
		function save()
		{
			var segment = '<?php echo Request::segment(1) ?>';
			$('#btnSave').text('Saving...'); //change button text
			$('#btnSave').attr('disabled',true); //set button disable 
			var id = $('#id').val();
			if(save_method == 'add') {
				url = "{{URL::to('/')}}"+"/"+segment;
				message='Data Saved Successfully';
			} else {
				url = "{{ URL::to('/')}}"+"/"+segment+"/"+ id;
				message='Data Updated Successfully';
			}
	
			$.ajax({
				url : url,
				type: "POST",
				data: $('#new_form').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					$('#id').val(''); //clear ID value
					// Show Success Message
					if(data.status)
					{
						$.gritter.add({
							title: 'Saved:',
							text: message
						});
					}
					
					$('#btnSave').text('Save'); //change button text
					$('#btnSave').attr('disabled',false); //set button enable 
					
					reload_table(); // List table reloaded
					
					$('#modal_form').modal('hide'); // Modal form hide				
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					// Show Error Message
					$.gritter.add({
						title: 'Error:',
						text: 'Data Not Saved'
					});

					$('#btnSave').text('Save'); //change button text
					$('#btnSave').attr('disabled',false); //set button enable 
				}
			});
		}
		
		function add()
		{
			save_method = 'add';
			document.getElementById("post_method").innerHTML = "";
			$('#new_form')[0].reset(); // reset form on modals
			$('.form-group').removeClass('has-error'); // clear error class
			$('.help-block').empty(); // clear error string
			$('#modal_form').modal('show'); // show bootstrap modal
			$('.modal-title').text('Add: Loan Config'); // Set Title to Bootstrap modal title
		}
		
		function edit(id)
		{
		
			var segment = '<?php echo Request::segment(1) ?>';
			var url = "{{ url('') }}"+"/"+segment+"/"+ id+"/edit";	
			document.getElementById("post_method").innerHTML = "<input type='hidden' name='_method' value='PUT' />";		
			save_method = 'update';
			$('#new_form')[0].reset(); // reset form on modals
			$('.form-group').removeClass('has-error'); // clear error class
			$('.help-block').empty(); // clear error string
			$.ajax({
				url : url,			
				type: "GET",
				dataType: "JSON",
				success: function(data)
				{
					$('[name="loan_config_id"]').val(data.loan_config_id);             
					$('[name="interest_cal_method"]').val(data.interest_cal_method);                   
					$('[name="is_another_method_allowed"]').val(data.is_another_method_allowed);                   
					$('[name="is_multiple_loan_allow_primary"]').val(data.is_multiple_loan_allow_primary);                   
					$('[name="additional_fee_label"]').val(data.additional_fee_label);                   
					$('[name="insurance_amount_label"]').val(data.insurance_amount_label);                   
					$('[name="is_rebate_allow_death"]').val(data.is_rebate_allow_death);                   
					$('[name="is_insurance_amount_edit"]').val(data.is_insurance_amount_edit);                   
					$('[name="is_multiple_one_time_loan_allow"]').val(data.is_multiple_one_time_loan_allow);                   
					$('[name="is_first_payment_edit"]').val(data.is_first_payment_edit);                   
					$('[name="is_loan_cycle_edit"]').val(data.is_loan_cycle_edit);                   
					$('[name="disburse_amount_bank_payment"]').val(data.disburse_amount_bank_payment);                   
					$('[name="max_no_installment"]').val(data.max_no_installment);                   
					$('[name="eligible_int_cal_dfd_loan"]').val(data.eligible_int_cal_dfd_loan);                   
					$('[name="is_loan_form_fee_show"]').val(data.is_loan_form_fee_show);                   
					$('[name="max_age_member"]').val(data.max_age_member);                   
					$('[name="is_loan_security_option_on"]').val(data.is_loan_security_option_on);                   
					$('[name="is_mfs_transaction_allow"]').val(data.is_mfs_transaction_allow);                   
					$('[name="is_loan_audit_fee_editable"]').val(data.is_loan_audit_fee_editable);                   
					$('[name="status"]').val(data.status);                     
					$('#modal_form').modal('show'); // show bootstrap modal when complete loaded
					$('.modal-title').text('Edit: Loan Config'); // Set title to Bootstrap modal title
					$('#btnSave').text('Update'); //change button text
				}
			});
		}
	</script>
	
	
	
	<!-- Start Bootstrap modal -->
	<div class="modal fade" id="modal_form" role="dialog" data-keyboard="false" data-backdrop="static">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
					<h4 class="modal-title"></h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>				
				<br>
				<form class="form-horizontal" role="form" method="POST" id="new_form">
					{{ csrf_field() }}
					<span id="post_method"></span>
					
					<input type="hidden" class="form-control" value="" name="loan_config_id" id="id">
					
						<div class="form-group row m-b-15" style="padding-left: 30px;">
							<label class="col-form-label col-md-5">Default interest calculation method </label>
							<div class="col-md-6">
								<select class="form-control m-b-5" name="interest_cal_method" id="interest_cal_method">
									<option value="1">Declaing Balance</option>
									<option value="2">True Declaing</option>
									<option value="3">Flat</option>
								</select>
								<small class="f-s-12 text-grey-darker"></small>
							</div>
						</div>
						<div class="form-group row m-b-15" style="padding-left: 30px;">
							<label class="col-form-label col-md-5">Is Other Calculation Method Allowed </label>
							<div class="col-md-6">
								<select class="form-control m-b-5" name="is_another_method_allowed" id="is_another_method_allowed">
									<option value="1">Yes</option>
									<option value="2">No</option>
								</select>
								<small class="f-s-12 text-grey-darker"></small>
							</div>
						</div>
						<div class="form-group row m-b-15" style="padding-left: 30px;">
							<label class="col-form-label col-md-5">Is Multiple Loan Allowed for Prtimary Products </label>
							<div class="col-md-6">
								<select class="form-control m-b-5" name="is_multiple_loan_allow_primary" id="is_multiple_loan_allow_primary">
									<option value="1">Yes</option>
									<option value="2">No</option>
								</select>
								<small class="f-s-12 text-grey-darker"></small>
							</div>
						</div>
						<div class="form-group row m-b-15" style="padding-left: 30px;">
							<label class="col-form-label col-md-5">Additional Fee label Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" value="" name="additional_fee_label" id="additional_fee_label">
								<small class="f-s-12 text-grey-darker"></small>
							</div>
						</div>
						<div class="form-group row m-b-15" style="padding-left: 30px;">
							<label class="col-form-label col-md-5">Insuarance Amount label Name</label>
							<div class="col-md-6">
								<input type="text" class="form-control" value="" name="insurance_amount_label" id="insurance_amount_label">
								<small class="f-s-12 text-grey-darker"></small>
							</div>
						</div>
						<div class="form-group row m-b-15" style="padding-left: 30px;">
							<label class="col-form-label col-md-5">Is Loan Rebate allowed diring Loan weraver for death member</label>
							<div class="col-md-6">
								<select class="form-control m-b-5" name="is_rebate_allow_death" id="is_rebate_allow_death">
									<option value="1">Yes</option>
									<option value="2">No</option>
								</select>
								<small class="f-s-12 text-grey-darker"></small>
							</div>
						</div>
						<div class="form-group row m-b-15" style="padding-left: 30px;">
							<label class="col-form-label col-md-5">Is Insurance Amount Editable</label>
							<div class="col-md-6">
								<select class="form-control m-b-5" name="is_insurance_amount_edit" id="is_insurance_amount_edit">
									<option value="1">Yes</option>
									<option value="2">No</option>
								</select>
								<small class="f-s-12 text-grey-darker"></small>
							</div>
						</div>
						<div class="form-group row m-b-15" style="padding-left: 30px;">
							<label class="col-form-label col-md-5">Is multiple one time loan disburse allowed</label>
							<div class="col-md-6">
								<select class="form-control m-b-5" name="is_multiple_one_time_loan_allow" id="is_multiple_one_time_loan_allow">
									<option value="1">Yes</option>
									<option value="2">No</option>
								</select>
								<small class="f-s-12 text-grey-darker"></small>
							</div>
						</div>
						<div class="form-group row m-b-15" style="padding-left: 30px;">
							<label class="col-form-label col-md-5">Is First Payment editable</label>
							<div class="col-md-6">
								<select class="form-control m-b-5" name="is_first_payment_edit" id="is_first_payment_edit">
									<option value="1">Yes</option>
									<option value="2">No</option>
								</select>
								<small class="f-s-12 text-grey-darker"></small>
							</div>
						</div>
						<div class="form-group row m-b-15" style="padding-left: 30px;">
							<label class="col-form-label col-md-5">Is Loan cycle editable</label>
							<div class="col-md-6">
								<select class="form-control m-b-5" name="is_loan_cycle_edit" id="is_loan_cycle_edit">
									<option value="1">Yes</option>
									<option value="2">No</option>
								</select>
								<small class="f-s-12 text-grey-darker"></small>
							</div>
						</div>
						<div class="form-group row m-b-15" style="padding-left: 30px;">
							<label class="col-form-label col-md-5">Loan disbursement amount for Bank Payment</label>
							<div class="col-md-6">
								<select class="form-control m-b-5" name="disburse_amount_bank_payment" id="disburse_amount_bank_payment">
									<option value="1">Yes</option>
									<option value="2">No</option>
								</select>
								<small class="f-s-12 text-grey-darker"></small>
							</div>
						</div>
						<div class="form-group row m-b-15" style="padding-left: 30px;">
							<label class="col-form-label col-md-5">Maximum number of installment</label>
							<div class="col-md-6">
								<input type="text" class="form-control" value="" name="max_no_installment" id="max_no_installment">
								<small class="f-s-12 text-grey-darker"></small>
							</div>
						</div>
						<div class="form-group row m-b-15" style="padding-left: 30px;">
							<label class="col-form-label col-md-5">Eligible interest calculate for daily basis DFD loan</label>
							<div class="col-md-6">
								<select class="form-control m-b-5" name="eligible_int_cal_dfd_loan" id="eligible_int_cal_dfd_loan">
									<option value="1">Yes</option>
									<option value="2">No</option>
								</select>
								<small class="f-s-12 text-grey-darker"></small>
							</div>
						</div>
						<div class="form-group row m-b-15" style="padding-left: 30px;">
							<label class="col-form-label col-md-5">IS loan form fee will be shown in loan disburse page</label>
							<div class="col-md-6">
								<select class="form-control m-b-5" name="is_loan_form_fee_show" id="is_loan_form_fee_show">
									<option value="1">Yes</option>
									<option value="2">No</option>
								</select>
								<small class="f-s-12 text-grey-darker"></small>
							</div>
						</div>
						<div class="form-group row m-b-15" style="padding-left: 30px;">
							<label class="col-form-label col-md-5">Maximum member age for etting loan</label>
							<div class="col-md-6">
								<select class="form-control m-b-5" name="max_age_member" id="max_age_member">
									<option value="1">Yes</option>
									<option value="2">No</option>
								</select>
								<small class="f-s-12 text-grey-darker"></small>
							</div>
						</div>
						<div class="form-group row m-b-15" style="padding-left: 30px;">
							<label class="col-form-label col-md-5">Is Loan security option enable</label>
							<div class="col-md-6">
								<select class="form-control m-b-5" name="is_loan_security_option_on" id="is_loan_security_option_on">
									<option value="1">Yes</option>
									<option value="2">No</option>
								</select>
								<small class="f-s-12 text-grey-darker"></small>
							</div>
						</div>
						<div class="form-group row m-b-15" style="padding-left: 30px;">
							<label class="col-form-label col-md-5">Is MFS Transaction Allowed</label>
							<div class="col-md-6">
								<select class="form-control m-b-5" name="is_mfs_transaction_allow" id="is_mfs_transaction_allow">
									<option value="1">Yes</option>
									<option value="2">No</option>
								</select>
								<small class="f-s-12 text-grey-darker"></small>
							</div>
						</div>
						<div class="form-group row m-b-15" style="padding-left: 30px;">
							<label class="col-form-label col-md-5">Is Loan audit fee editable</label>
							<div class="col-md-6">
								<select class="form-control m-b-5" name="is_loan_audit_fee_editable" id="is_loan_audit_fee_editable">
									<option value="1">Yes</option>
									<option value="2">No</option>
								</select>
								<small class="f-s-12 text-grey-darker"></small>
							</div>
						</div>
						<div class="form-group row m-b-15" style="padding-left: 30px;">
							<label class="col-form-label col-md-5">Status</label>
							<div class="col-md-6">
								<select class="form-control m-b-5" name="status" id="status">
									<option value="1">Active</option>
									<option value="2">Deactive</option>
								</select>
								<small class="f-s-12 text-grey-darker"></small>
							</div>
						</div>


					<div class="modal-footer">
						<button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					</div>
				</form>
				
				
				
				
				
				
				
				
				
			</div>
		</div>
	</div>
	<!-- End Bootstrap modal -->
	
	@endsection	

