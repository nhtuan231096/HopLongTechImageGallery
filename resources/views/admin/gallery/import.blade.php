@extends('layouts.admin')
@section('title','Quản lý thư viện hình ảnh sản phẩm')
@section('links','gallery')
@section('main')
<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title">Import Image Gallery</h3>
	</div>
	<div class="panel-body">
		@if(Session::has('success'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			{{Session::get('success')}}
		</div>
		@elseif(Session::has('error'))
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			{{Session::get('error')}}
		</div>
		@endif
		<div class="jumbotron">
			<div class="container">
				<p>
					<form action="" method="POST" class="form-inline" role="form" enctype="multipart/form-data">
						@csrf
						<div class="form-group">
							<label class="sr-only" for="">label</label>
							<input type="file" class="form-control" name="import_file" placeholder="Input field" required>
						</div>
					
						
					
						<button type="submit" class="btn btn-primary">Import</button>
					</form>
				</p>
			</div>
		</div>
	</div>
</div>
@stop()