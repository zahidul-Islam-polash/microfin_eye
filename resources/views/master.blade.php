<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>{{ $heading}}</title>
	<link rel="shortcut icon" href="{{asset('public/cdip.png')}}">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="{{asset('assets/css/default/app.min.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/plugins/gritter/css/jquery.gritter.css')}}" rel="stylesheet" />
	<!-- ================== END BASE CSS STYLE ================== -->
	

	
	<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
	<?php if($page_type == 1) { ?>
	<link href="{{asset('assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
	<?php } ?>
	<!-- ================== END PAGE LEVEL STYLE ================== -->
	
</head>
<body>
	
		<!-- begin #page-loader -->
	<div id="page-loader" class="fade show">
		<span class="spinner"></span>
	</div>
	<!-- end #page-loader -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="page-container fade page-without-sidebar page-header-fixed page-with-top-menu">
		<!-- begin #header -->
		<div id="header" class="header navbar-default">
			<!-- begin navbar-header -->
			<div class="navbar-header">
				<a href="{{URL::to('/')}}" class="navbar-brand"><img src="{{asset('public/uploads/cdip.png')}}" /> <b> &nbsp;&nbsp; CDIP </b>&nbsp;&nbsp;  MICROFIN EYE &nbsp;&nbsp; <i class="fa fa-money-bill-alt"></i></a>
				<button type="button" class="navbar-toggle" data-click="top-menu-toggled">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<!-- end navbar-header --><!-- begin header-nav -->
			<ul class="navbar-nav navbar-right">
				<li class="navbar-form">
					<form action="" method="POST" name="search">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Enter keyword" />
							<button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
						</div>
					</form>
				</li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown" class="dropdown-toggle f-s-14">
						<i class="fa fa-bell"></i>
						<span class="label">5</span>
					</a>
					<div class="dropdown-menu media-list dropdown-menu-right">
						<div class="dropdown-header">NOTIFICATIONS (5)</div>
						<a href="javascript:;" class="dropdown-item media">
							<div class="media-left">
								<i class="fa fa-bug media-object bg-silver-darker"></i>
							</div>
							<div class="media-body">
								<h6 class="media-heading">Server Error Reports <i class="fa fa-exclamation-circle text-danger"></i></h6>
								<div class="text-muted f-s-10">3 minutes ago</div>
							</div>
						</a>
						<a href="javascript:;" class="dropdown-item media">
							<div class="media-left">
								<img src="assets/img/user/user-1.jpg" class="media-object" alt="" />
								<i class="fab fa-facebook-messenger text-blue media-object-icon"></i>
							</div>
							<div class="media-body">
								<h6 class="media-heading">John Smith</h6>
								<p>Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>
								<div class="text-muted f-s-10">25 minutes ago</div>
							</div>
						</a>
						<a href="javascript:;" class="dropdown-item media">
							<div class="media-left">
								<img src="assets/img/user/user-2.jpg" class="media-object" alt="" />
								<i class="fab fa-facebook-messenger text-blue media-object-icon"></i>
							</div>
							<div class="media-body">
								<h6 class="media-heading">Olivia</h6>
								<p>Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>
								<div class="text-muted f-s-10">35 minutes ago</div>
							</div>
						</a>
						<a href="javascript:;" class="dropdown-item media">
							<div class="media-left">
								<i class="fa fa-plus media-object bg-silver-darker"></i>
							</div>
							<div class="media-body">
								<h6 class="media-heading"> New User Registered</h6>
								<div class="text-muted f-s-10">1 hour ago</div>
							</div>
						</a>
						<a href="javascript:;" class="dropdown-item media">
							<div class="media-left">
								<i class="fa fa-envelope media-object bg-silver-darker"></i>
								<i class="fab fa-google text-warning media-object-icon f-s-14"></i>
							</div>
							<div class="media-body">
								<h6 class="media-heading"> New Email From John</h6>
								<div class="text-muted f-s-10">2 hour ago</div>
							</div>
						</a>
						<div class="dropdown-footer text-center">
							<a href="javascript:;">View more</a>
						</div>
					</div>
				</li>
				<li class="dropdown navbar-user">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img src="{{asset(Session::get('user_photo'))}}" alt="" /> 
						<span class="d-none d-md-inline">{{Session::get('user_name')}}</span> <b class="caret"></b>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<a href="javascript:;" class="dropdown-item">Edit Profile</a>
						<a href="javascript:;" class="dropdown-item"><span class="badge badge-danger pull-right">2</span> Inbox</a>
						<a href="javascript:;" class="dropdown-item">Calendar</a>
						<a href="javascript:;" class="dropdown-item">Setting</a>
						<div class="dropdown-divider"></div>
						<a href="{{URL::to('/logout')}}" class="dropdown-item">Log Out</a>
					</div>
				</li>
			</ul>
			<!-- end header-nav -->
		</div>
		<!-- end #header -->
		
		<!-- begin #top-menu -->
		<div id="top-menu" class="top-menu">
			<!-- begin nav -->
			<ul class="nav">

				

				
			<?php 
				$navbars 	= DB::table('user_nav_menu')->where('status', 1)->orderBy('nav_sl','ASC')->get();	
				$menus 	  	= DB::table('user_menu')->where('status',1)->orderBy('menu_sl')->get();
				$sub_menus 	= DB::table('user_sub_menu')->where('status',1)->orderBy('sub_menu_sl')->get();
			?>
				
				
			<?php foreach($navbars as $navbar) { ?>
			
				<?php if($navbar->has_menu ==0) { ?>
				<li>
					<a href="{{URL::to('/')}}/<?php echo $navbar->nav_link; ?>">
						<i class="<?php echo $navbar->style_class; ?>"></i>
						<span><?php echo $navbar->nav_name; ?></span>
					</a>
				</li>
				<?php } else { ?>
				
				
				<li class="has-sub">
					<a href="javascript:;">
						<i class="<?php echo $navbar->style_class; ?>"></i>
						<span><?php echo $navbar->nav_name; ?></span>
						<b class="caret"></b>
					</a>
					<ul class="sub-menu">
						<?php foreach($menus as $menu) { ?>
							
							<?php if ($navbar->nav_id == $menu->nav_id) { ?>
							
								<?php if($menu->has_sub_menu) { ?>
								<li class="has-sub">
									<a href="javascript:;"><?php echo $menu-> menu_name?><b class="caret"></b></a>
									
									<ul class="sub-menu">
										<?php foreach ($sub_menus as $sub_menu) { ?>
											<?php if ($sub_menu->menu_id == $menu->menu_id) { ?>
												<li><a href="{{URL::to('/')}}/<?php echo $sub_menu->sub_menu_link?>"><?php echo $sub_menu->sub_menu_name; ?></a></li>
											<?php } ?>
										<?php } ?>
									</ul>
									
								</li>
								<?php } else { ?>
								<li><a href="{{URL::to('/')}}/<?php echo $menu->menu_link?>"><?php echo $menu-> menu_name?></a></li>
								<?php } ?>
							
							<?php } ?>
							
						<?php } ?>
					</ul>
				</li>
				
				<?php } ?>
				
			<?php } ?>
		

				
				<li class="menu-control menu-control-left">
					<a href="javascript:;" data-click="prev-menu"><i class="fa fa-angle-left"></i></a>
				</li>
				<li class="menu-control menu-control-right">
					<a href="javascript:;" data-click="next-menu"><i class="fa fa-angle-right"></i></a>
				</li>
			</ul>
			<!-- end nav -->
		</div>
		<!-- end #top-menu -->
		
		
		<!-- Start Dynamic Content -->
		@yield('main_content')
		<!-- end Dynamic Content -->
		
		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->
	
	
		
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{{asset('assets/js/app.min.js')}}"></script>
	<script src="{{asset('assets/js/theme/default.min.js')}}"></script>
	<script src="{{asset('assets/plugins/gritter/js/jquery.gritter.js')}}"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<?php if($page_type == 1) { ?>
	<script src="{{asset('assets/plugins/datatables.net/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
	<script src="{{asset('assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
	<script src="{{asset('assets/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
	<script>
		var table;
		var segment = '<?php echo Request::segment(1) ?>';
		var url = "{{URL::to('/all-data-')}}"+segment; 
		$(document).ready(function() {
		   table = $('#data-table-default').DataTable({
				"processing": true,
				"serverSide": true,
				"responsive": true,
				"ajax":{
					"url": url,
					"dataType": "json",
					"type": "POST",
					"data":{ _token: "{{csrf_token()}}"}
				   },
				"columns": [
				<?php foreach($colums as $key => $colum){ ?>
				{ "data": "<?php echo $key; ?>" },
				<?php } ?>
				]    
			});
		});

		function reload_table()
		{
			table.ajax.reload(null,false); //reload datatable ajax 
		}
	</script>
	<?php } ?>
	<!-- ================== END PAGE LEVEL JS ================== -->

</body>
</html>