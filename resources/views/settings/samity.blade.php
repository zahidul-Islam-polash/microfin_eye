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
			
			<!-- begin panel -->
			<div class="panel panel-inverse">
				<div class="panel-heading">
					<h4 class="panel-title">Panel Title here</h4>
					<div class="panel-heading-btn">
						<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
					</div>
				</div>
				<div class="panel-body">
				
					<form class="form-horizontal" action="{{URL::to($action)}}" role="form" method="POST" id="form" enctype="multipart/form-data">
						{{ csrf_field() }}
						{!!$method_control!!}
						<input type="hidden" class="form-control" name="samity_id" id="id" value="<?php echo $samity_id; ?>">
						
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Branch</label>
							<div class="col-md-2">
								<select name="branch_id" id="branch_id" class="form-control" required> 
									<option value="" hidden>-SELECT-</option>
									<?php foreach($branches as $branch) { ?>
									<option value="<?php echo $branch->branch_code; ?>"><?php echo $branch->branch_name; ?></option>
									<?php } ?>
								<select>
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Samity Name</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="samity_name" id="samity_name" value="<?php echo $samity_name; ?>" required />
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Samity Name (Bangla)</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="samity_name_bn" id="samity_name_bn" value="<?php echo $samity_name_bn; ?>" required />
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Samity Code</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="samity_code" id="samity_code" value="<?php echo $samity_code; ?>" required />
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Max Member</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="max_member" id="max_member" value="<?php echo $max_member; ?>" required />
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Min Member</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="min_member" id="min_member" value="<?php echo $min_member; ?>" required />
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Member Type</label>
							<div class="col-md-2">
								<select name="member_type" id="member_type" class="form-control">
									<option value="1">Male</option>
									<option value="2">Female</option>
									<option value="3">3rd</option>
								<select>
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Samity Type</label>
							<div class="col-md-2">			
								<select name="samity_type" id="samity_type" class="form-control">
									<option value="1">Monthly</option>
									<option value="2">Weekly</option>
									<option value="3">Daily</option>
									<option value="4">Yearly</option>
								<select>
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Opening Date</label>
							<div class="col-md-2">
								<input type="date" class="form-control" name="samity_opening_date" id="samity_opening_date" value="<?php echo $samity_opening_date; ?>" required />
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Closing Date</label>
							<div class="col-md-2">
								<input type="date" class="form-control" name="samity_closing_date" id="samity_closing_date" value="<?php echo $samity_closing_date; ?>" />
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Latitude</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="samity_lat" id="samity_lat" value="<?php echo $samity_lat; ?>" />
							</div>
						</div>	
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Longitude</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="samity_lon" id="samity_lon" value="<?php echo $samity_lon; ?>"/>
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Status</label>
							<div class="col-md-2">
								<select name="status" id="status" class="form-control">
									<option value="1">Activeted</option>
									<option value="2">Cancelled</option>
								<select>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-7 offset-md-3">
								<button type="submit" id="submit" class="btn btn-sm btn-primary m-r-5"><?php echo $button; ?></button>
								<button type="reset" class="btn btn-sm btn-default">Cancel</button>
							</div>
						</div>
					</form>
				
				</div>
			</div>
			<!-- end panel -->

	
		<!-- end #content -->
		
		<script>
			document.getElementById("branch_id").value = '<?php echo $branch_id ?>';
			document.getElementById("member_type").value = '<?php echo $member_type ?>';
			document.getElementById("samity_type").value = '<?php echo $samity_type ?>';
			document.getElementById("status").value = '<?php echo $status ?>';
		</script>

@endsection	