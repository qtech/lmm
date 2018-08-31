@extends('layout.main')

@section('content')

<div class="tbl">
	<div class="tbl-row">
		<div class="tbl-cell">
			<h3>Add New Video</h3>
			<small class="text-muted custom-alignment">Please add relevant video names. They will be displayed as a target in mobile apps with the link.</small>
		</div>		
		<div class="tbl-cell tbl-cell-action">
			<a href="{{route('videos.index')}}" class="btn btn-secondary pull-right"><i class="fa fa-hand-o-left"></i> Back</a>
		</div>
	</div>
</div>

<div class="box-typical box-typical-padding">
	<form action="{{route('videos.store')}}" method="POST" enctype="multipart/form-data">
	{{csrf_field()}}	
	
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Video Name</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="video_name" name="video_name" placeholder="Video Name" maxlength="75" value="{{old('video_name')}}">
			<small class="text-muted">Max length 75 - "Longer names = low attraction."</small></p>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Video Link</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="video_link" name="video_link" placeholder="Video Link" maxlength="255" value="{{old('video_link')}}">
			<small class="text-muted">Max length 255 - "Verify the link before you add. Invalid URL's will be rejected."</small></p>
		</div>
	</div>
	
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Video Image</label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<input type="file" class="form-control" id="video_image" name="video_image">
				<small class="text-muted">This image will be used as a banner/thumbnail for this video.</small></p>
			</p>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms"></label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save </button>
				<a href="{{route('videos.index')}}" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
			</p>
		</div>
	</div>
	</form>
</div>

@endsection