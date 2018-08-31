@extends('layout.main')

@section('content')
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>Videos</h3>				
				<small class="text-muted custom-alignment">List of all the videos with their links.</small>
			</div>	
			<div class="tbl-cell tbl-cell-action">
				<a href="{{route('videos.add')}}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add Video</a>
			</div>	
		</div>
	</div>
	<table id="table-edit" class="table table-bordered table-hover">
				<thead>
				<tr>	
					<th style="text-align: center">Image</th>				
					<th style="text-align: center">Video Name</th>	
					<th style="text-align: center">Video Link</th>					
					<th style="text-align: center">Added On</th>
					<th style="text-align: center" colspan="2">Actions</th>					
				</tr>
				</thead>
				<tbody>					
					@forelse($videos as $video)
					<tr style="text-align: center">
						<td><img width="100px" class="img-responsive" style="border-radius: 50px;" src="{{asset(getenv('IMG_VIEW').$video->image)}}"></td>
						<td>{{$video->name}}</td>
						<td><a href="{{$video->video_link}}" target="_blank">{{$video->video_link}}</a></td>
						<td>{{$video->created_at->toFormattedDateString()}}</td>						
						<td width="5">
							<a href="{{route('videos.edit',['id'=>$video->video_id])}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
						</td>
						<td width="5">
							<a href="#" class="btn btn-danger btn-sm"
										data-toggle="modal"
										data-target=".bd-example-modal-sm{{$video->video_id}}">
								<i class="fa fa-trash-o"></i>
							</a>

							<div class="modal fade bd-example-modal-sm{{$video->video_id}}"
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
									<p>	Are you sure you want to delete this video? </p>
										<p><strong style="color: red"> Warning! </strong>This will also remove the <strong>image</strong> from this server.</p>
									</div>
									<div class="modal-footer">	
										<form action="{{route('videos.delete',['id'=>$video->video_id])}}" method="POST">		
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
						<td colspan="8">No images found. Please add some images to gallery.</td>
					</tr>
					@endforelse
				</tbody>
			</table>
			<div class="custom-paginate">
			{{$videos->links()}}	
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