@extends('layout.main')

@section('content')
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>Slider Images</h3>				
				<small class="text-muted custom-alignment">Home Page Slider Image.</small>
			</div>	
			{{-- <div class="tbl-cell tbl-cell-action">
				<a href="{{route('latin.add')}}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add Songs</a>
			</div>	 --}}
		</div>
	</div>
	<table id="table-edit" class="table table-bordered table-hover">
				<thead>
				<tr>				
					<th style="text-align: center">Name</th>
					<th style="text-align: center">Image</th>	
					<th style="text-align: center">Actions</th>					
				</tr>
				</thead>
				<tbody>					
					@forelse($images as $image)
					<tr style="text-align: center">
					<td>{{$image->name}}</td>
						<td ><img width="50px" class="img-responsive" style="border-radius: 50px;" src="{{config('app.url')}}storage/uploads/{{$image->image}}"></td>
					<td width="5"><a href="{{route('slider.edit',['id'=>$image->id])}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a></td>
					</tr>
					@empty
					<tr>
						<td colspan="8">No Images available.</td>
					</tr>
					@endforelse
				</tbody>
			</table>

@endsection