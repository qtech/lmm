@extends('layout.main')

@section('content')
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>Songs in <label class="label label-primary">{{$genres->genres_name}}</label> Genre</h3>				
			</div>	
			<div class="tbl-cell tbl-cell-action">
				<a href="{{route('songs.add',['id'=>$genres->genres_id])}}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add Songs</a>
			</div>	
			<div class="tbl-cell tbl-cell-action" style="width: 100px;">
				<a href="{{route('musicgenres.index')}}" class="btn btn-secondary pull-right"><i class="fa fa-hand-o-left"></i> Back</a>
			</div>
			
		</div>
	</div>
	<table id="table-edit" class="table table-bordered table-hover">
				<thead>
				<tr>	
					<th style="text-align: center">Image</th>				
					<th style="text-align: center">Song Name</th>
					<th style="text-align: center">Artist Name</th>
					<th style="text-align: center">Player</th>				
					<th style="text-align: center">Duration</th>
					<th style="text-align: center">Added On</th>
					<th style="text-align: center">Place</th>						
					<th style="text-align: center" colspan="2">Actions</th>					
				</tr>
				</thead>
				<tbody>					
					@forelse($songs as $song)
					<tr style="text-align: center">
						<td width="65"><img width="50px" class="img-responsive" style="border-radius: 50px;" src="{{asset(getenv('IMG_VIEW').$song->image)}}"></td>
						<td>{{$song->song_name}}</td>
						<td>{{$song->artist_name}}</td>						
						<td>
							<audio controls>
							@if($song->song_url == NULL)							  
							  <source src="{{asset(getenv('IMG_VIEW').$song->song_server_url)}}" type="audio/mpeg">
							@else
							  <source src="{{$song->song_url}}" type="audio/mpeg">
							@endif
								Your browser does not support the audio element.
							</audio></td>
						<td width="30">{{$song->song_time}}</td>
						<td>{{$song->created_at->toFormattedDateString()}}</td>						
						<td width="10">
							@if($song->song_url == NULL)
								<label class="label label-warning">Server</label>
							@else
								<label class="label label-success">External</label>
							@endif
						</td>
						<td width="5"><a href="{{route('songs.edit',['id'=>$song->song_id])}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a></td>

						<td width="5">
							<a href="#" class="btn btn-danger btn-sm"
										data-toggle="modal"
										data-target=".bd-example-modal-sm{{$song->song_id}}">
								<i class="fa fa-trash-o"></i>
							</a>

							<div class="modal fade bd-example-modal-sm{{$song->song_id}}"
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
										<h4 class="modal-title" id="myModalLabel">Confirm Action?</h4>
									</div>
									<div class="modal-body">
									<p>	Are you sure you want to delete <strong>"{{$song->song_name}}"</strong> song. </p>
										<p><strong style="color: red"> Warning! </strong>This will also remove the <strong>image banner</strong> and the <strong>actual song </strong> from this server if the song place is server.</p>
									</div>
									<div class="modal-footer">	
										<form action="{{route('songs.delete',['id'=>$song->song_id])}}" method="POST">
										<input type="hidden" name="genres_id" value="{{$song->genres_id}}">
										{{csrf_field()}}
										{{method_field('DELETE')}}
										<button type="submit" class="btn btn-danger">Delete</button>
										</form>									
									</div>
								</div>
							</div>
							</div><!--.modal-->
						</td>
					</tr>
					@empty
					<tr>
						<td colspan="8">No songs available.</td>
					</tr>
					@endforelse
				</tbody>
			</table>
			<div class="custom-paginate">
			{{$songs->links()}}	
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