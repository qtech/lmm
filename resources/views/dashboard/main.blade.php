@extends('layout.main')

@section('content')
<div class="col-sm-3">
<a href="{{route('musicgenres.index')}}">
	<section class="widget widget-simple-sm">
		<div class="widget-simple-sm-icon" style="background-color:#cd6724; color: white ">
			{{$genres}}			
		</div>
		<div class="widget-simple-sm-bottom">
			<a href="{{route('musicgenres.index')}}"><i class="fa fa-music" style="color: #cd6724;"></i> Genres</a>
		</div>
	</section><!--.widget-simple-sm-->
</a>
</div>

<div class="col-sm-3">
<a href="{{route('albums.index')}}">
	<section class="widget widget-simple-sm">
		<div class="widget-simple-sm-icon" style="background-color:#1b99cf; color: white ">
			{{$albums}}			
		</div>
		<div class="widget-simple-sm-bottom">
			<a href="{{route('albums.index')}}"><i class="fa fa-folder-o" aria-hidden="true" style="color: #1b99cf;"></i> Artists</a>
		</div>
	</section><!--.widget-simple-sm-->
</a>
</div>

<div class="col-sm-3">
<a href="{{route('latin.index')}}">
	<section class="widget widget-simple-sm">
		<div class="widget-simple-sm-icon" style="background-color:#ac6bec; color: white ">
			{{$latinsingles}}			
		</div>
		<div class="widget-simple-sm-bottom">
			<a href="{{route('latin.index')}}"><i class="fa fa-pagelines" style="color: #ac6bec;"></i> DJ Mixes</a>
		</div>
	</section><!--.widget-simple-sm-->
</a>
</div>

<div class="col-sm-3">
<a href="{{route('djproducts.index')}}">
	<section class="widget widget-simple-sm">
		<div class="widget-simple-sm-icon" style="background-color:#f29824; color: white ">
			{{$djproducts}}			
		</div>
		<div class="widget-simple-sm-bottom">
			<a href="{{route('english.index')}}"><i class="fa fa-edge" style="color: #f29824;"></i> DJ Products</a>
		</div>
	</section>
</a>
</div>

<!-- <div class="col-sm-3">
<a href="{{route('videos.index')}}">
	<section class="widget widget-simple-sm">
		<div class="widget-simple-sm-icon" style="background-color:#f29824; color: white ">
			{{$videos}}			
		</div>
		<div class="widget-simple-sm-bottom">
			<a href="{{route('videos.index')}}"><i class="fa fa-video-camera" style="color: #f29824;"></i> Videos</a>
		</div>
	</section>.widget-simple-sm
</a>
</div> -->

<div class="col-sm-3">
<a href="{{route('gallerys.index')}}">
	<section class="widget widget-simple-sm">
		<div class="widget-simple-sm-icon" style="background-color:#21a788; color: white ">
			{{$gallery}}			
		</div>
		<div class="widget-simple-sm-bottom">
			<a href="{{route('gallerys.index')}}"><i class="fa fa-files-o" style="color: #21a788;"></i> Gallery</a>
		</div>
	</section>
</a>
</div>

<!-- <div class="col-sm-3">
<a href="{{route('events.index')}}">
	<section class="widget widget-simple-sm">
		<div class="widget-simple-sm-icon" style="background-color:#46c35f; color: white ">
			{{$events}}			
		</div>
		<div class="widget-simple-sm-bottom">
			<a href="{{route('events.index')}}"><i class="fa fa-sticky-note" style="color: #46c35f;"></i> Events</a>
		</div>
	</section>
</a>
</div> -->

@endsection
