@extends('layout.main')

@section('content')

<div class="tbl">
	<div class="tbl-row">
		<div class="tbl-cell">
			<h3>Add New Genre</h3>
			<small class="text-muted custom-alignment">Add a name and an image for this genre.</small>
		</div>		
		<div class="tbl-cell tbl-cell-action">
			<a href="{{route('musicgenres.index')}}" class="btn btn-secondary pull-right"><i class="fa fa-hand-o-left"></i> Back</a>
		</div>
	</div>
</div>

<div class="box-typical box-typical-padding">
	<form action="{{route('musicgenres.store')}}" method="POST" enctype="multipart/form-data">
	{{csrf_field()}}
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Genre Name</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="genres_name" name="genres_name" placeholder="Genre Name" maxlength="40" value="{{old('genres_name')}}">
			<small class="text-muted">Max length 40 - "The shorter the better"</small></p>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Genre Image</label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<input type="file" class="form-control" id="genres_image" name="genres_image">
			</p>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms"></label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save </button>
				<a href="{{route('musicgenres.index')}}" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
			</p>
		</div>
	</div>
	</form>
</div>
	

@endsection