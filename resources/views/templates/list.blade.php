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
			<div class="panel panel-inverse">
				<!-- begin panel-heading -->
				<div class="panel-heading">
					<div class="panel-title">
						<a class="btn btn-xs btn-icon btn-circle btn-success" onclick="reload_table();"><i class="fa fa-redo"></i></a></td>
					</div>
					<div class="panel-heading-btn">
						<a href="{{URL::to('/')}}/{{ Request::segment(1)}}/create" class="btn btn-sm btn-danger"> <i class="fa fa-plus"></i> <?php echo $add_button; ?></a> 
					</div>
				</div>
				<!-- end panel-heading -->
				<!-- begin panel-body -->
				
				<div class="panel-body">
					<table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
						<thead>							
							<tr>
							<?php $i = 0; foreach($colums as $key => $colum) { ?>
								<?php if($key == 'action') { $orderable = "false"; } else { $orderable = "true"; }?>
								<th data-orderable="<?php echo $orderable; ?>"><?php echo $colum; ?></th>
							<?php } ?>
							</tr>						
						</thead>
						<tbody>
	
						</tbody>
					</table>
				</div>
				<!-- end panel-body -->
			</div>
			<!-- end panel -->
			
		</div>
		<!-- end #content -->

@endsection	