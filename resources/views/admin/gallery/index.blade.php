@extends('layouts.admin')
@section('title','Quản lý thư viện hình ảnh sản phẩm')
@section('links','gallery')
@section('main')
<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title">Danh sách</h3>
	</div>
	<div class="panel-body">
		<table class="table table-hover">
			<thead>
				<tr>
					<th>STT</th>
					<th>Tiêu đề</th>
					<th>Người tạo</th>
					<th>Ngày tạo</th>
					<th>Xem</th>
				</tr>
			</thead>
			<tbody>
				@foreach($dataGallery as $key=>$itemGallery)
				<tr>
					<td>{{$key}}</td>
					<td>{{$itemGallery->title}}</td>
					<td>{{$itemGallery->created_by}}</td>
					<td>{{date_format($itemGallery->created_at,'d-m-Y')}}</td>
					<td>
						<a href="{{route('viewImageGallery',['title'=>$itemGallery->title])}}" target="_blank" class="fa fa-eye"></a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		{{$dataGallery->links()}}
	</div>
</div>
@stop()