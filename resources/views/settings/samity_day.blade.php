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
			$('.modal-title').text('Add: Samity Day'); // Set Title to Bootstrap modal title
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
					$('[name="samity_day_id"]').val(data.samity_day_id);             
					$('[name="samity_id"]').val(data.samity_id);                   
					$('[name="day_id"]').val(data.day_id);                   
					$('[name="from_date"]').val(data.from_date);                   
					$('[name="to_date"]').val(data.to_date);                   
					$('[name="status"]').val(data.status);                     
					$('#modal_form').modal('show'); // show bootstrap modal when complete loaded
					$('.modal-title').text('Edit: Samity Day'); // Set title to Bootstrap modal title
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
					
					<input type="hidden" class="form-control" value="" name="samity_day_id" id="id">

					<div class="form-group">
						<label class="control-label col-md-4">Samity :</label>
						<div class="col-md-6">
							<select name="samity_id" id="samity_id" class="form-control" required> 
								<option value="" hidden>-SELECT-</option>
								<?php foreach($samities as $samity) { ?>
								<option value="<?php echo $samity->samity_id; ?>"><?php echo $samity->samity_name; ?></option>
								<?php } ?>
							<select>
							<span class="help-block"></span>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-4">Day :</label>
						<div class="col-md-6">
							<select name="day_id" id="day_id" class="form-control" required> 
								<option value="" hidden>-SELECT-</option>
								<?php foreach($days as $day) { ?>
								<option value="<?php echo $day->working_day_id; ?>"><?php echo $day->working_day_name; ?></option>
								<?php } ?>
							<select>
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4">From Date :</label>
						<div class="col-md-6">
							<input type="date" name="from_date" id="from_date" class="form-control">
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4">To Date :</label>
						<div class="col-md-6">
							<input type="date" name="to_date" id="to_date" class="form-control">
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4">Status:</label>
						<div class="col-md-6">
							<select name="status" id="status" class="form-control">
								<option value="1">Activeted</option>
								<option value="2">Cancelled</option>
							<select>
							<span class="help-block"></span>
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

