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
						<input type="hidden" class="form-control" name="nav_id" id="id" value="<?php echo $nav_id; ?>">
						
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Nav Name</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="nav_name" id="nav_name" value="<?php echo $nav_name; ?>" required />
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Style Class</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="style_class" id="style_class" value="<?php echo $style_class; ?>"  />
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Has Menu</label>
							<div class="col-md-2">
								<select name="has_menu" id="has_menu" class="form-control">
									<option value="1">Yes</option>
									<option value="0">No</option>
								<select>
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Nav Link</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="nav_link" id="nav_link" value="<?php echo $nav_link; ?>" />
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Nav Sl</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="nav_sl" id="nav_sl" value="<?php echo $nav_sl; ?>" />
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
			document.getElementById("has_menu").value = '<?php echo $has_menu ?>';
			document.getElementById("status").value = '<?php echo $status ?>';
		</script>

@endsection	