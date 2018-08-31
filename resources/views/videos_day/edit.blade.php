@extends('layout.main')

@section('content')

<div class="tbl">
	<div class="tbl-row">
		<div class="tbl-cell">
			<h3>Edit this video</h3>
			<small class="text-muted custom-alignment">Change only the required information.</small>
		</div>		
		<div class="tbl-cell tbl-cell-action">
			<a href="{{route('videos-of-the-day.index')}}" class="btn btn-secondary pull-right"><i class="fa fa-hand-o-left"></i> Back</a>
		</div>
	</div>
</div>

<div class="box-typical box-typical-padding">
	<form action="{{route('videos-of-the-day.update',['id'=>$video->id])}}" method="POST" enctype="multipart/form-data">
	{{csrf_field()}}	
	{{method_field('PUT')}}
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Video Name</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="video_name" name="video_name" placeholder="Video Name" maxlength="75" value="{{$video->name}}">
			<small class="text-muted">Max length 75 - "Longer names = low attraction."</small></p>
		</div>
	</div>

		<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Link Type</label>
		<div class="col-sm-9 ajdust-label-forms">			
			<div class="radio col-sm-3">
				<input type="radio" class="song_type" name="song_type" id="server" value="server" checked>
				<label for="server">Video Link </label>				
			</div>
			<div class="radio col-sm-5">
				<input type="radio" class="song_type" name="song_type" id="url" value="url" >
				<label for="url">Video Link (Embeded Code)</label>
			</div>
		</div>
	</div>

	<div id="songType">
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Video Link</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="video_link" name="video_link" placeholder="Video Link" maxlength="255" value="{{$video->video_link}}">
			<small class="text-muted">Max length 255 - "Verify the link before you add. Invalid URL's will be rejected."</small></p>
		</div>
	</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Description</label>
		<div class="col-sm-9">
			<p class="form-control-static"><textarea id="new_event" name="description" class="form-control">{{$video->description}}</textarea>
			</p>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Video Image</label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<input type="file" class="form-control" id="video_image" name="video_image">
				<small class="text-muted">This image will be used as a banner/thumbnail for this video (minimum size:-350*350).</small></p>
			</p>
		</div>
	</div>

		<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Banner Image</label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<input type="file" class="form-control" id="video_image" name="banner_image">
				<small class="text-muted">This image will be used as a banner/thumbnail for this video (minimum size:-720*500).</small></p>
			</p>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms"></label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save </button>
				<a href="{{route('videos.index')}}" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
			</p>
		</div>
	</div>
	</form>
</div>

	<script type="text/javascript">
	$(document).ready(function() {		
		
		$('.song_type').on('change',function(){
			$radioValue = $("input[name=song_type]:checked").val();
			if($radioValue == "url")
			{
				jQuery('div#songType').html('<div class="form-group row"><label class="col-sm-3 form-control-label ajdust-label-forms">Embeded Link</label><div class="col-sm-9"><p class="form-control-static"><textarea id="new_event" name="video_link_embeded" class="form-control"></textarea></p></div></div>');
			}
			else
			{
		jQuery('div#songType').html('<div class="form-group row"><label class="col-sm-3 form-control-label ajdust-label-forms">Video Link</label><div class="col-sm-9"><p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="video_link" name="video_link" placeholder="Video Link" maxlength="255" value="{{$video->video_link}}"><small class="text-muted">Max length 255 - "Verify the link before you add. Invalid URLs will be rejected."</small></p></div></div>');
			}
		});		
	});
</script>

@endsection