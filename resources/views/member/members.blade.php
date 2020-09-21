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
			<h1 class="page-header">Manage {{ $heading }} <small>{{ $Sub_heading }}</small></h1>
			<!-- end page-header -->
			<!-- begin panel -->
			
			
		<div class="col-xl-12">

			<div class="panel panel-inverse panel-with-tabs" data-sortable-id="ui-unlimited-tabs-1">

				<div class="panel-heading p-0">
					<div class="tab-overflow">
						<ul class="nav nav-tabs nav-tabs-inverse">
							<li class="nav-item prev-button"><a href="javascript:;" data-click="prev-tab" class="nav-link text-primary"><i class="fa fa-arrow-left"></i></a></li>
							<li class="nav-item"><a href="#nav-tab-1" data-toggle="tab" class="nav-link active">General</a></li>
							<li class="nav-item"><a href="#nav-tab-2" data-toggle="tab" class="nav-link">Nav Tab 2</a></li>
							<li class="nav-item"><a href="#nav-tab-3" data-toggle="tab" class="nav-link">Nav Tab 3</a></li>
						</ul>
					</div>
				</div>


				<div class="panel-body tab-content">

					<div class="tab-pane fade active show" id="nav-tab-1">
						<h3 class="m-t-10">Members General Information</h3>
						
						<form class="form-horizontal" role="form" method="POST" id="new_form">
							{{ csrf_field() }}
							{!!$method_control!!}
							
							<input type="hidden" class="form-control" name="member_id" id="id" value="<?php echo $member_id; ?>">
							
							<div class="form-group row m-b-6">
								<label class="col-md-2 col-form-label">Member Code</label>
								<div class="col-md-2">
									<input type="text" class="form-control" name="member_code" id="member_code" value="<?php echo $member_code; ?>" required />
								</div>
							</div>
							<div class="form-group row m-b-6">
								<label class="col-md-2 col-form-label">Member Name</label>
								<div class="col-md-2">
									<input type="text" class="form-control" name="member_name" id="member_name" value="<?php echo $member_name; ?>"  />
								</div>
							</div>
							<div class="form-group row m-b-6">
								<label class="col-md-2 col-form-label">Date of Birth</label>
								<div class="col-md-2">
									<input type="date" class="form-control" name="member_dob" id="member_dob" value="<?php echo $member_dob; ?>"  />
								</div>
							</div>
							<div class="form-group row m-b-6">
								<label class="col-md-2 col-form-label">Gender</label>
								<div class="col-md-2">
									<select name="member_gender" id="member_gender" class="form-control">
										<option value="1">Male</option>
										<option value="2">Female</option>
									<select>
								</div>
							</div>
							<div class="form-group row m-b-6">
								<label class="col-md-2 col-form-label">Samity</label>
								<div class="col-md-2">
									<select name="member_samity_id" id="member_samity_id" class="form-control">
										<option value="1">Yes</option>
										<option value="0">No</option>
									<select>
								</div>
							</div> 
							<div class="form-group row m-b-6">
								<label class="col-md-2 col-form-label">Member Contact</label>
								<div class="col-md-2">
									<input type="text" class="form-control" name="member_contact" id="member_contact" value="<?php echo $member_contact; ?>"  />
								</div>
							</div>
							<div class="form-group row m-b-6">
								<label class="col-md-2 col-form-label">Member NID</label>
								<div class="col-md-2">
									<input type="text" class="form-control" name="member_nid" id="member_nid" value="<?php echo $member_nid; ?>"  />
								</div>
							</div>
							
							<div class="form-group row m-b-6">
								<label class="col-md-2 col-form-label">Member Photo</label>
								<div class="col-md-2">
									<input type="text" class="form-control" name="member_photo" id="member_photo" value="<?php echo $member_photo; ?>"  />
								</div>
							</div>
							<div class="form-group row m-b-6">
								<label class="col-md-2 col-form-label">Admission Date</label>
								<div class="col-md-2">
									<input type="text" class="form-control" name="member_admission_date" id="member_admission_date" value="<?php echo $member_admission_date; ?>"  />
								</div>
							</div>
							<div class="form-group row m-b-6">
								<label class="col-md-2 col-form-label">Status</label>
								<div class="col-md-2">
									<select name="member_status" id="member_status" class="form-control">
										<option value="1">Activeted</option>
										<option value="2">Cancelled</option>
									<select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-7 offset-md-3">
									<button type="button" id="btnSave" onclick="save()" class="btn btn-primary"><?php echo $button; ?></button>
									<button type="reset" class="btn btn-sm btn-default">Cancel</button>
								</div>
							</div>
						</form>
					</div>
					
					<div class="tab-pane fade" id="nav-tab-2">
						<h3 class="m-t-10">Nav Tab 2</h3>
					</div>

					<div class="tab-pane fade" id="nav-tab-3">
						<h3 class="m-t-10">Nav Tab 3</h3>
					</div>
					
				</div>

			</div>

		</div>




			
			<!-- begin panel -->
			<!--<div class="panel panel-inverse">
				<div class="panel-heading">
					<h4 class="panel-title">Panel Title here</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
				</div>
				<div class="panel-body">
				
				

				
				</div>
			</div> -->
			<!-- end panel -->

	
		<!-- end #content -->
		
	<script>
		function save()
		{
			var segment = '<?php echo Request::segment(1) ?>';
			$('#btnSave').text('Saving...'); //change button text
			$('#btnSave').attr('disabled',true); //set button disable 
			var id = $('#id').val();
			if(id == '') {
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
	</script>

@endsection	