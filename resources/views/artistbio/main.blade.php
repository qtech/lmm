@extends('layout.main')

@section('content')
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>Artists Biographies</h3>				
				<small class="text-muted custom-alignment">List of artists biographies added so far. Change or delete them and it will reflect in the mobile apps.</small>
			</div>	
			<div class="tbl-cell tbl-cell-action">
				<a href="{{route('artists_bio.add')}}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add Artist Biography</a>
			</div>	
		</div>
	</div>
	<table id="table-edit" class="table table-bordered table-hover">
				<thead>
				<tr>	
					<th style="text-align: center">Thumbnail</th>									
					<th style="text-align: center">Artist Name</th>										
					<th style="text-align: center">Instagram URL</th>
					<th style="text-align: center">Banner</th>
					<th style="text-align: center">Added On</th>					
					<th style="text-align: center" colspan="2">Actions</th>					
				</tr>
				</thead>
				<tbody>					
					@forelse($artists_bio as $bio)
					<tr style="text-align: center">
						<td width="65"><img width="50px" class="img-responsive" style="border-radius: 50px;" src="{{config('app.url')}}/core/public/storage/uploads/{{$bio->thumb}}"></td>
						<td>
							@if(isset($bio->artists->album_name))
								{{@$bio->artists->album_name}}
							@endif
						</td>	
						<td><a href="{{$bio->insta_url}}" target="_blank">{{$bio->insta_url}}</a></td>
						<td width="65"><img width="50px" class="img-responsive" style="border-radius: 50px;" src="{{config('app.url')}}/core/public/storage/uploads/{{$bio->banner}}"></td>
						<td>{{$bio->created_at->toFormattedDateString()}}</td>						
						<td width="5"><a href="{{route('artists_bio.edit',['id'=>$bio->bio_id])}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a></td>
						<td width="5">
							<a href="#" class="btn btn-danger btn-sm"
										data-toggle="modal"
										data-target=".bd-example-modal-sm{{$bio->bio_id}}">
								<i class="fa fa-trash-o"></i>
							</a>

							<div class="modal fade bd-example-modal-sm{{$bio->bio_id}}"
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
									<p>	Are you sure you want to delete <strong>"{{$bio->artist_name}}"</strong> biography. </p>
										<p><strong style="color: red"> Warning! </strong>This will also remove the <strong>image banner</strong> and <strong>thumbnail</strong> from this server.</p>
									</div>
									<div class="modal-footer">	
										<form action="{{route('artists_bio.delete',['id'=>$bio->bio_id])}}" method="POST">										
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
			{{$artists_bio->links()}}	
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
