@extends('layout.main')

@section('content')

<div class="tbl">
	<div class="tbl-row">
		<div class="tbl-cell">
			<h3>Edit Song <label class="label label-primary">{{$song->song_name}}</label></h3>
			<small class="text-muted custom-alignment">Edit only the required information.</small>
		</div>		
		<div class="tbl-cell tbl-cell-action">
			<a href="{{route('audio-of-the-day.index')}}" class="btn btn-secondary pull-right"><i class="fa fa-hand-o-left"></i> Back</a>
		</div>
	</div>
</div>

<div class="box-typical box-typical-padding">
	<form action="{{route('audio-of-the-day.update',['id'=>$song->song_id])}}" method="POST" enctype="multipart/form-data">
	{{csrf_field()}}	
	{{method_field('PUT')}}
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Song Name</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="song_name" name="song_name" placeholder="Song Name" maxlength="100" value="{{$song->song_name}}">
			<small class="text-muted">Max length 100</small></p>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Artist Name</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="artist_name" name="artist_name" placeholder="Artist Name" maxlength="50" value="{{$song->artist_name}}">
			<small class="text-muted">Max length 50</small></p>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Song Upload Type</label>
		<div class="col-sm-9 ajdust-label-forms">			
			<div class="radio col-sm-3">
				<input type="radio" class="song_type" name="song_type" id="server" value="server" 
				@if($song->song_server_url != NULL)
					checked
				@endif
				>
				<label for="server">Upload File </label>				
			</div>
			<div class="radio col-sm-5">
				<input type="radio" class="song_type" name="song_type" id="url" value="url"
				@if($song->song_url != NULL)
					checked
				@endif
				>
				<label for="url">Song URL (External Source)</label>
			</div>
		</div>
	</div>	
	<div id="songType"></div>

	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Song Image Banner</label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<input type="file" class="form-control" id="song_banner" name="song_banner">
				<small class="text-muted">This image will be used as a banner for this song (minimum size:-350*350).</small></p>
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

<script type="text/javascript">
	$(document).ready(function() {		
		$radioValue = $("input[name=song_type]:checked").val();
		if($radioValue == "server")
		{
			jQuery('div#songType').html('<div class="form-group row"><label class="col-sm-3 form-control-label ajdust-label-forms">Upload Song</label><div class="col-sm-9"><p class="form-control-static"><input type="file" class="form-control" id="song" name="song"><small class="text-muted">Max File size allowed is 60 MB.</small></p></div></div>');
		}
		else
		{
			jQuery('div#songType').html('<div class="form-group row"><label class="col-sm-3 form-control-label ajdust-label-forms">Song URL</label><div class="col-sm-9"><p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="song_url" name="song_url" placeholder="Song URL" maxlength="255" value="{{$song->song_url}}"><small class="text-muted">Max length 255</small></p></div></div>');
		}

		$('.song_type').on('change',function(){
			$radioValue = $("input[name=song_type]:checked").val();

			if($radioValue == "url")
			{
				jQuery('div#songType').html('<div class="form-group row"><label class="col-sm-3 form-control-label ajdust-label-forms">Song URL</label><div class="col-sm-9"><p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="song_url" name="song_url" placeholder="Song URL" maxlength="255"><small class="text-muted">Max length 255</small></p></div></div>');
			}
			else
			{
				jQuery('div#songType').html('<div class="form-group row"><label class="col-sm-3 form-control-label ajdust-label-forms">Upload Song</label><div class="col-sm-9"><p class="form-control-static"><input type="file" class="form-control" id="song" name="song"><small class="text-muted">Max File size allowed is 60 MB.</small></p></div></div>');
			}
		});		
	});
</script>
	

@endsection