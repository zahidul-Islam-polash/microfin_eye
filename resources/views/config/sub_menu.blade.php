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
						<input type="hidden" class="form-control" name="sub_menu_id" id="id" value="<?php echo $sub_menu_id; ?>">
						
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label"> Select menu</label>
							<div class="col-md-2">
								<select name="menu_id" id="menu_id" class="form-control">
									<?php foreach($menus as $menu) { ?>
									<option value="<?php echo $menu->menu_id; ?>"><?php echo $menu->menu_name; ?></option>
									<?php } ?>
								<select>
							</div>
						</div>
						
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Sub Menu Name</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="sub_menu_name" id="sub_menu_name" value="<?php echo $sub_menu_name; ?>" required />
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Style Class</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="style_css" id="style_css" value="<?php echo $style_css; ?>"  />
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Sub Menu Link</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="sub_menu_link" id="sub_menu_link" value="<?php echo $sub_menu_link; ?>" />
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Sub Menu Sl</label>
							<div class="col-md-2">
								<input type="text" class="form-control" name="sub_menu_sl" id="sub_menu_sl" value="<?php echo $sub_menu_sl; ?>" />
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
			document.getElementById("menu_id").value = '<?php echo $menu_id ?>';
			document.getElementById("status").value = '<?php echo $status ?>';
		</script>

@endsection	