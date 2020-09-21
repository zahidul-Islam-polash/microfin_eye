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
						<input type="hidden" class="form-control" name="branch_id" id="id" value="<?php echo $branch_id; ?>">
						
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Branch Name</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="branch_name" id="branch_name" value="<?php echo $branch_name; ?>" required />
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Branch Code</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="branch_code" id="branch_code" value="<?php echo $branch_code; ?>" required />
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Opening Date</label>
							<div class="col-md-2">
								<input type="date" class="form-control" name="branch_opening_date" id="branch_opening_date" value="<?php echo $branch_opening_date; ?>" required />
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Closing Date</label>
							<div class="col-md-2">
								<input type="date" class="form-control" name="branch_closing_date" id="branch_closing_date" value="<?php echo $branch_closing_date; ?>" />
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Latitude</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="branch_lat" id="branch_lat" value="<?php echo $branch_lat; ?>" />
							</div>
						</div>	
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Longitude</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="branch_lon" id="branch_lon" value="<?php echo $branch_lon; ?>"/>
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
			document.getElementById("status").value = '<?php echo $status ?>';
		</script>

@endsection	