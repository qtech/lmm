@extends('layout.main')

@section('content')
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>Gallery</h3>				
				<small class="text-muted custom-alignment">List of Images</small>
			</div>	
			<div class="tbl-cell tbl-cell-action">
				<a href="{{route('gallerys.add')}}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add Image</a>
			</div>	
		</div>
	</div>
	<table id="table-edit" class="table table-bordered table-hover">
				<thead>
				<tr>	
					<th style="text-align: center">Image</th>							
					<th style="text-align: center">Added On</th>
					<th style="text-align: center" colspan="2">Actions</th>					
				</tr>
				</thead>
				<tbody>					
					@forelse($galleries as $gallery)
					<tr style="text-align: center">
						<td><img width="100px" class="img-responsive" style="border-radius: 50px;" src="{{config('app.url')}}storage/uploads/{{$gallery->image}}"></td>
						<td>{{$gallery->created_at->toFormattedDateString()}}</td>						
						<td>
							<a href="#" class="btn btn-danger btn-sm"
										data-toggle="modal"
										data-target=".bd-example-modal-sm{{$gallery->gallery_id}}">
								<i class="fa fa-trash-o"></i>
							</a>

							<div class="modal fade bd-example-modal-sm{{$gallery->gallery_id}}"
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
									<p>	Are you sure you want to delete this image? </p>
										<p><strong style="color: red"> Warning! </strong>This will also remove the <strong>image</strong> from this server.</p>
									</div>
									<div class="modal-footer">	
										<form action="{{route('gallerys.delete',['id'=>$gallery->gallery_id])}}" method="POST">		
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
			{{$galleries->links()}}	
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