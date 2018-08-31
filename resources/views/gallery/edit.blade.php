@extends('layout.main')

@section('content')

<div class="tbl">
	<div class="tbl-row">
		<div class="tbl-cell">
			<h3>Edit this Image</h3>
			<small class="text-muted custom-alignment">Select an image from your device and select a folder to which that image should be added. It will automatically reflect in the mobile apps.</small>
		</div>		
		<div class="tbl-cell tbl-cell-action">
			<a href="{{route('gallerys.index')}}" class="btn btn-secondary pull-right"><i class="fa fa-hand-o-left"></i> Back</a>
		</div>
	</div>
</div>

<div class="box-typical box-typical-padding">
	<form action="{{route('gallerys.update',['id'=>$gallery->gallery_id])}}" method="POST" enctype="multipart/form-data">
	{{csrf_field()}}	
	{{method_field('PUT')}}
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Image</label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<input type="file" class="form-control" id="gallery_image" name="gallery_image">
				<small class="text-muted">This image will be uploaded.</small></p>
			</p>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms"></label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save </button>
				<a href="{{route('gallerys.index')}}" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
			</p>
		</div>
	</div>
	</form>
</div>

@endsection