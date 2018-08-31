@extends('layout.main')

@section('content')

<div class="tbl">
	<div class="tbl-row">
		<div class="tbl-cell">
			<h3>App Share links</h3>
			<small class="text-muted custom-alignment">Current links to iOS and Android app share links. Click on save if you decide to change them.</small>
		</div>				
	</div>
</div>

<div class="box-typical box-typical-padding">
	<form action="{{route('shares.update',['id'=>$share->share_id])}}" method="POST" enctype="multipart/form-data">
	{{csrf_field()}}	
	{{method_field('PUT')}}
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">iOS Link</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="ios_link" name="ios_link" placeholder="iOS link" maxlength="255" value="{{$share->ios_link}}">
			<small class="text-muted">Max length 255 - "Please verify URL else it will be rejected."</small></p>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Android Link</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="android_link" name="android_link" placeholder="Android link" maxlength="255" value="{{$share->android_link}}">
			<small class="text-muted">Max length 255 - "Please verify URL else it will be rejected."</small></p>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Text</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="text" name="text" placeholder="iOS link" maxlength="100" value="{{$share->text}}">
			<small class="text-muted">Max length 100 - "Short text to show above the share links."</small></p>
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