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
						<input type="hidden" class="form-control" name="menu_id" id="id" value="<?php echo $menu_id; ?>">
						
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label"> Select Nav</label>
							<div class="col-md-2">
								<select name="nav_id" id="nav_id" class="form-control">
									<?php foreach($navs as $nav) { ?>
									<option value="<?php echo $nav->nav_id; ?>"><?php echo $nav->nav_name; ?></option>
									<?php } ?>
								<select>
							</div>
						</div>
						
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Menu Name</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="menu_name" id="menu_name" value="<?php echo $menu_name; ?>" required />
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Style Class</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="style_css" id="style_css" value="<?php echo $style_css; ?>"  />
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Has Sub Menu</label>
							<div class="col-md-2">
								<select name="has_sub_menu" id="has_sub_menu" class="form-control">
									<option value="1">Yes</option>
									<option value="0">No</option>
								<select>
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Menu Link</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="menu_link" id="menu_link" value="<?php echo $menu_link; ?>" />
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Menu Sl</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="menu_sl" id="menu_sl" value="<?php echo $menu_sl; ?>" />
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
			document.getElementById("nav_id").value = '<?php echo $nav_id ?>';
			document.getElementById("has_sub_menu").value = '<?php echo $has_sub_menu ?>';
			document.getElementById("status").value = '<?php echo $status ?>';
		</script>

@endsection	