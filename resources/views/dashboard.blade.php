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
			<h1 class="page-header">Manage {{ $heading }} <?php echo $heading; ?> <small>{{ $Sub_heading }} </small></h1>
			<!-- end page-header -->
			<!-- begin panel -->
				<!-- begin row -->
				<div class="row">
					<!-- begin col-3 -->
					<div class="col-xl-3 col-md-6">
						<div class="widget widget-stats bg-blue">
							<div class="stats-icon"><i class="fa fa-desktop"></i></div>
							<div class="stats-info">
								<h4>TOTAL VISITORS</h4>
								<p>3,291,922</p>	
							</div>
							<div class="stats-link">
								<a href="javascript:;">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
							</div>
						</div>
					</div>
					<!-- end col-3 -->
					<!-- begin col-3 -->
					<div class="col-xl-3 col-md-6">
						<div class="widget widget-stats bg-info">
							<div class="stats-icon"><i class="fa fa-link"></i></div>
							<div class="stats-info">
								<h4>BOUNCE RATE</h4>
								<p>20.44%</p>	
							</div>
							<div class="stats-link">
								<a href="javascript:;">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
							</div>
						</div>
					</div>
					<!-- end col-3 -->
					<!-- begin col-3 -->
					<div class="col-xl-3 col-md-6">
						<div class="widget widget-stats bg-orange">
							<div class="stats-icon"><i class="fa fa-users"></i></div>
							<div class="stats-info">
								<h4>UNIQUE VISITORS</h4>
								<p>1,291,922</p>	
							</div>
							<div class="stats-link">
								<a href="javascript:;">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
							</div>
						</div>
					</div>
					<!-- end col-3 -->
					<!-- begin col-3 -->
					<div class="col-xl-3 col-md-6">
						<div class="widget widget-stats bg-red">
							<div class="stats-icon"><i class="fa fa-clock"></i></div>
							<div class="stats-info">
								<h4>AVG TIME ON SITE</h4>
								<p>00:12:23</p>	
							</div>
							<div class="stats-link">
								<a href="javascript:;">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
							</div>
						</div>
					</div>
					<!-- end col-3 -->
				</div>
				<!-- end row -->
			<!-- end panel -->
			
		</div>
		<!-- end #content -->
		
		@endsection	
		
		
		
	