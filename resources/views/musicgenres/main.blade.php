@extends('layout.main')

@section('content')

<div class="tbl">
	<div class="tbl-row">
		<div class="tbl-cell">
			<h3>Genres<small class="text-muted"></small></h3>
		</div>
		<div class="tbl-cell tbl-cell-action">
			<a href="{{route('musicgenres.create')}}" class="btn pull-right"><i class="fa fa-plus"></i> Add Genre</a>
		</div>
	</div>
</div>

@forelse($allgenres as $genres)
<div class="col-sm-6 col-md-4 col-xl-3">	
	<article class="card-user box-typical">
		<a href="{{route('musicgenres.edit',['id'=>$genres->genres_id])}}" class="float-left label label-primary">
			<i class="fa fa-pencil"></i>
		</a>	
		<a href="#" class="float-right label label-danger" data-toggle="modal"
						data-target=".bd-example-modal-sm{{$genres->genres_id}}">
			<i class="fa fa-remove"></i>
		</a>
		<div class="modal fade bd-example-modal-sm{{$genres->genres_id}}"
					 tabindex="-1"
					 role="dialog"
					 aria-labelledby="mySmallModalLabel"
					 aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
							<i class="font-icon-close-2"></i>
						</button>
						<h4 class="modal-title" id="myModalLabel">Confirm Delete?</h4>
					</div>
					<div class="modal-body">
						<p>Are you sure you wish to delete "<strong>{{$genres->genres_name}}</strong>"?</p>
						<p><strong style="color: red"> Warning! </strong>This will also remove the image file from storage.</p>
					</div>
					<div class="modal-footer custom-modal-alignment">	
						<form action="{{route('musicgenres.delete',['id'=>$genres->genres_id])}}" method="POST">
						{{csrf_field()}}
						{{method_field('DELETE')}}
							<button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete</button>							
						</form>				
					</div>
				</div>
			</div>
		</div><!--.modal-->
		<a href="{{route('songs.index',['id'=>$genres->genres_id])}}">
			<div class="card-user-photo">
				<img style="border-radius:5px !important; height:75px;" src="{{asset(getenv('IMG_VIEW').$genres->image)}}" alt="">
			</div>
		</a>
		<div class="card-user-name" style="text-transform: uppercase;">{{$genres->genres_name}}</div>
		<div class="card-user-status">{{$genres->songs->count()}} - Songs</div>						
	</article><!--.card-user-->	
</div>
@empty
	<div class="alert alert-danger alert-icon alert-close alert-dismissible fade in" role="alert">
		<i class="font-icon font-icon-inline font-icon-warning"></i>
		<strong>No Genres Found.</strong><br>
		We are sorry, but we were not able to find any genres. Please add some genres in order for them to show here. Genres name are really important as they will be showed in the Mobile apps. Make them small and meaningful.		
	</div>

@endforelse
<div class="custom-paginate">
{{$allgenres->links()}}	
</div>
<style type="text/css">
	.custom-paginate li {
	    float: left;
	    padding: 10px;
	    font-size: 25px;
    	font-weight: bold;
	}
	.custom-paginate {
	    float: left;
	    clear: left;
	}

</style>

@endsection