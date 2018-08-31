@extends('layout.main')

@section('content')

<div class="tbl">
	<div class="tbl-row">
		<div class="tbl-cell">
			<h3>Edit Artist <label class="label label-primary">{{$album->album_name}}</label></h3>
			<small class="text-muted custom-alignment">This will also reflect in the Featured artist menu.</small>
		</div>		
		<div class="tbl-cell tbl-cell-action">
			<a href="{{route('albums.index')}}" class="btn btn-secondary pull-right"><i class="fa fa-hand-o-left"></i> Back</a>
		</div>
	</div>
</div>

<div class="box-typical box-typical-padding">
	<form action="{{route('albums.update',['id'=>$album->album_id])}}" method="POST" enctype="multipart/form-data">
	{{csrf_field()}}	
	{{method_field('PUT')}}
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Artist Name</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="album_name" name="album_name" placeholder="Artist Name" maxlength="50" value="{{$album->album_name}}">
			<small class="text-muted">Max length 50</small></p>
		</div>
	</div>

	<!-- <div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Artists Instagram URL</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="insta_url" name="insta_url" placeholder="Artists Instagram URL" maxlength="255" value="{{$album->insta_url}}">
			<small class="text-muted">Max length 255</small></p>
		</div>
	</div> -->
	
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Artist Image</label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<input type="file" class="form-control" id="album_image" name="album_image">
				<small class="text-muted">This image will be used as a banner for this album.</small></p>
			</p>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms"></label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save </button>
				<a href="{{route('albums.index')}}" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
			</p>
		</div>
	</div>
	</form>
</div>

@endsection