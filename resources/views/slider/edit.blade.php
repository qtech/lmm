@extends('layout.main')

@section('content')

<div class="tbl">
	<div class="tbl-row">
		<div class="tbl-cell">
			<h3>Edit Image <label class="label label-primary">{{$images->name}}</label></h3>
			<small class="text-muted custom-alignment">Edit only the required information.</small>
		</div>		
		<div class="tbl-cell tbl-cell-action">
			<a href="{{route('slider.index')}}" class="btn btn-secondary pull-right"><i class="fa fa-hand-o-left"></i> Back</a>
		</div>
	</div>
</div>

<div class="box-typical box-typical-padding">
	<form action="{{route('slider.update',['id'=>$images->id])}}" method="POST" enctype="multipart/form-data">
	{{csrf_field()}}	
	{{method_field('PUT')}}
	

	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Image</label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<input type="file" class="form-control" id="song_banner" name="image">
				<small class="text-muted">This image will be used as a banner for hone slider (minimum size:-1014 × 1133).</small></p>
			</p>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms"></label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save </button>
				<a href="{{route('audio-of-the-day.index')}}" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
			</p>
		</div>
	</div>
	</form>
</div>

	

@endsection