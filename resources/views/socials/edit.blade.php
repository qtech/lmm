@extends('layout.main')

@section('content')

<div class="tbl">
	<div class="tbl-row">
		<div class="tbl-cell">
			<h3>Edit Social Details</h3>
			<small class="text-muted custom-alignment">Please add valid URL for links.</small>
		</div>		
		<div class="tbl-cell tbl-cell-action">
			<a href="{{route('socials.index')}}" class="btn btn-secondary pull-right"><i class="fa fa-hand-o-left"></i> Back</a>
		</div>
	</div>
</div>

<div class="box-typical box-typical-padding">
	<form action="{{route('socials.update',['id'=>$social->social_id])}}" method="POST"	>
	{{csrf_field()}}	
	{{method_field('PUT')}}
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Social Name</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="social_name" name="social_name" placeholder="Social Name" maxlength="100" value="{{$social->social_name}}">
			<small class="text-muted">Max length 100 - "Small Names = More social attraction."</small></p>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Social Link</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="social_link" name="social_link" placeholder="Social Link" maxlength="255" value="{{$social->social_link}}">
			<small class="text-muted">Max length 255 - "Please enter valid URL for social link else it will be rejected."</small></p>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms"></label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save </button>
				<a href="{{route('socials.index')}}" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
			</p>
		</div>
	</div>
	</form>
</div>

@endsection