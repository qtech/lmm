@extends('layout.main')

@section('content')

<div class="tbl">
	<div class="tbl-row">
		<div class="tbl-cell">
			<h3>Add New Artist Biography Details</h3>
			<small class="text-muted custom-alignment">Please add relevant artist information.</small>
		</div>		
		<div class="tbl-cell tbl-cell-action">
			<a href="{{route('artists_bio.main')}}" class="btn btn-secondary pull-right"><i class="fa fa-hand-o-left"></i> Back</a>
		</div>
	</div>
</div>

<div class="box-typical box-typical-padding">
	<form action="{{route('artists_bio.store')}}" method="POST" enctype="multipart/form-data">
	{{csrf_field()}}	
	
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Artist Name</label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<select name="album_id" class="form-control">
					<option disabled="disabled" selected value="">Please select one</option>
					@foreach($artists as $artist)
						<option value="{{$artist->album_id}}">
							{{$artist->album_name}}
						</option>
					@endforeach
				</select>
			</p>
		</div>
	</div>
	{{-- <div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Artist Name</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="artist_name" name="artist_name" placeholder="Artist Name" maxlength="50" value="{{old('artist_name')}}">
			<small class="text-muted">Max length 50</small></p>
		</div>
	</div> --}}

	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Biography</label>
		<div class="col-sm-9">
			<p class="form-control-static"><textarea class="form-control summernote" name="biography">{{old('biography')}}</textarea>
			<small class="text-muted">Make it detailed. There is no restriction to its size.</small></p>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Artists Instagram URL</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="insta_url" name="insta_url" placeholder="Artists Instagram URL" maxlength="255" value="{{old('insta_url')}}">
			<small class="text-muted">Max length 255</small></p>
		</div>
	</div>
	
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Artist Thumbnail Image</label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<input type="file" class="form-control" id="thumb" name="thumb">
				<small class="text-muted">This image will be used as a thumbnail for this artist.</small></p>
			</p>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Artist Banner</label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<input type="file" class="form-control" id="banner" name="banner">
				<small class="text-muted">This image will be used as a banner for this artist.</small></p>
			</p>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms"></label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save </button>
				<a href="{{route('artists_bio.main')}}" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
			</p>
		</div>
	</div>
	</form>
</div>

@endsection
