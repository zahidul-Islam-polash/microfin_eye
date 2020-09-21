	@extends('master')
	@section('main_content')
	
	<style>
		.image-upload > input
		{
			display: none;
		}

		.image-upload img
		{
			margin-left:20%;
			margin-top:10px;
			width: 90;
			height:110;
			cursor: pointer;	
			background-color: #fff;
			border: 1px solid #ddd;
			border-radius: 4px;
			padding: 4px;
		}
	</style>
	
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
						<input type="hidden" class="form-control" name="user_id" id="id" value="<?php echo $user_id; ?>">
						
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">User Type</label>
							<div class="col-md-2">
								<select name="utype_id" id="utype_id" class="form-control" required> 
									<option value="" hidden>-SELECT-</option>
									<?php foreach($user_types as $user_type) { ?>
									<option value="<?php echo $user_type->id; ?>"><?php echo $user_type->utype_name; ?></option>
									<?php } ?>
								<select>
							</div>
						</div>
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
							<label class="col-md-2 col-form-label">Employee ID</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="emp_id" id="emp_id" value="<?php echo $emp_id; ?>" required />
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">User Name</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="user_name" id="user_name" value="<?php echo $user_name; ?>" required />
							</div>
						</div>
						<?php if($user_id == '') { ?>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Password</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="password" id="password" value="<?php echo $password; ?>" required />
							</div>
						</div>
						<?php } ?>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Photo</label>
							<div class="col-md-2">
								<label for="user_photo">
									<img id="blah" class="img-thumbnail" src="{{asset($user_photo)}}" width="90" height="110"/>
								</label>
								<input type="file" onchange="readURL(this);" class="form-control" name="user_photo" id="user_photo">
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
			document.getElementById("utype_id").value = '<?php echo $utype_id ?>';
			document.getElementById("branch_id").value = '<?php echo $branch_id ?>';
			document.getElementById("status").value = '<?php echo $status ?>';
		</script>
		<script>
			function readURL(input) {
				if (input.files && input.files[0]) {
					var reader = new FileReader();

					reader.onload = function (e) {
						$('#blah')
							.attr('src', e.target.result)
							.width(90)
							.height(110);
					};

					reader.readAsDataURL(input.files[0]);
				}
			}
		</script>

@endsection	