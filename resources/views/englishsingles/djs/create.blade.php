@extends('layout.main')

@section('content')

<div class="tbl">
	<div class="tbl-row">
		<div class="tbl-cell">
			<h3>Add New Dj</h3>
			<small class="text-muted custom-alignment">Please add relevant Dj names. They will be displayed as a list in Featured Djs menu.</small>
		</div>		
		<div class="tbl-cell tbl-cell-action">
			<a href="{{route('english.dj.main')}}" class="btn btn-secondary pull-right"><i class="fa fa-hand-o-left"></i> Back</a>
		</div>
	</div>
</div>

<div class="box-typical box-typical-padding">
	<form action="{{route('english.dj.store')}}" method="POST" enctype="multipart/form-data">
	{{csrf_field()}}	
	
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Djs Name</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="name" name="name" placeholder="Djs Name" maxlength="60" value="{{old('name')}}">
			<small class="text-muted">Max length 60</small></p>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Djs Instagram URL</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="insta_url" name="insta_url" placeholder="Djs Instagram URL" maxlength="255" value="{{old('insta_url')}}">
			<small class="text-muted">Max length 255</small></p>
		</div>
	</div>
	
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Djs Image</label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<input type="file" class="form-control" id="image" name="image">
				<small class="text-muted">This image will be used as a banner for this Dj.</small></p>
			</p>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms"></label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save </button>
				<a href="{{route('english.dj.main')}}" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
			</p>
		</div>
	</div>
	</form>
</div>

@endsection