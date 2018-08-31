@extends('layout.main')

@section('content')

<div class="tbl">
	<div class="tbl-row">
		<div class="tbl-cell">
			<h3>Biography</h3>
			<small class="text-muted custom-alignment">Give a catchy title and a good description.</small>
		</div>				
	</div>
</div>

<div class="box-typical box-typical-padding">
	<form action="{{route('bio.update',['id'=>$biography->bio_id])}}" method="POST" enctype="multipart/form-data">
	{{csrf_field()}}	
	{{method_field('PUT')}}	
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Title</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="title" name="title" placeholder="Biography Title" maxlength="255" value="{{$biography->title}}">
			<small class="text-muted">Max length 255</small></p>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Description</label>
		<div class="col-sm-9">
			<p class="form-control-static"><textarea id="biography" name="text" class="form-control">{{$biography->text}}</textarea></p>
		</div>
	</div>	
	
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms"></label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save </button>
			</p>
		</div>
	</div>
	</form>
</div>



@endsection