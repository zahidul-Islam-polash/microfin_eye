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
						<input type="hidden" class="form-control" name="samity_fo_id" id="id" value="<?php echo $samity_fo_id; ?>">
						
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Samity</label>
							<div class="col-md-2">
								<select name="samity_id" id="samity_id" class="form-control" required> 
									<option value="" hidden>-SELECT-</option>
									<?php foreach($samities as $samity) { ?>
									<option value="<?php echo $samity->samity_id; ?>"><?php echo $samity->samity_name; ?></option>
									<?php } ?>
								<select>
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">Field Officer</label>
							<div class="col-md-2">
								<select name="fo_id" id="fo_id" class="form-control" required> 
									<option value="" hidden>-SELECT-</option>
									<?php foreach($all_fo as $fo) { ?>
									<option value="<?php echo $fo->emp_id; ?>"><?php echo $fo->emp_name_eng.' ('.$fo->emp_id.')'; ?></option>
									<?php } ?>
								<select>
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">From Date</label>
							<div class="col-md-2">
								<input type="date" class="form-control" name="from_date" id="from_date" value="<?php echo $from_date; ?>" required />
							</div>
						</div>
						<div class="form-group row m-b-6">
							<label class="col-md-2 col-form-label">To Date</label>
							<div class="col-md-2">
								<input type="date" class="form-control" name="to_date" id="to_date" value="<?php echo $to_date; ?>" />
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
			document.getElementById("samity_id").value = '<?php echo $samity_id ?>';
			document.getElementById("fo_id").value = '<?php echo $fo_id ?>';
			document.getElementById("status").value = '<?php echo $status ?>';
		</script>

@endsection	