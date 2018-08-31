@extends('layout.main')

@section('content')

<div class="tbl">
	<div class="tbl-row">
		<div class="tbl-cell">
			<h3>OnAir Title and Links</h3>
			<small class="text-muted custom-alignment">Give it an appropriate title and a valid external source.</small>
		</div>				
	</div>
</div>

<div class="box-typical box-typical-padding">
	<form action="{{route('onair.update',['id'=>$onair->onair_id])}}" method="POST" enctype="multipart/form-data">
	{{csrf_field()}}	
	{{method_field('PUT')}}	
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">On Air Title</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="title" name="title" placeholder="On Air Title" maxlength="50" value="{{$onair->title}}">
			<small class="text-muted">Max length 50 - "Title's are supposed to be small and attractive."</small></p>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">On Air Link</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="link" name="link" placeholder="On Air Link" maxlength="255" value="{{$onair->link}}">
			<small class="text-muted">Max length 255 - "Please verify URL else it will be rejected. Make sure you link to an external mp3 source."</small></p>
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