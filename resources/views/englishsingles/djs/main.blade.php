@extends('layout.main')

@section('content')
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>Djs</h3>				
				<small class="text-muted custom-alignment">List of Djs</small>
			</div>	
			<div class="tbl-cell tbl-cell-action">
				<a href="{{route('english.dj.add')}}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add New Dj</a>
			</div>		
			<div class="tbl-cell tbl-cell-action" style="width: 100px !important;">
				<a href="{{route('english.index')}}" class="btn btn-secondary pull-right"><i class="fa fa-hand-o-left"></i> Back</a>
			</div>	
		</div>
	</div>
	<table id="table-edit" class="table table-bordered table-hover">
				<thead>
				<tr>	
					<th style="text-align: center">Image</th>
					<th style="text-align: center">Djs Name</th>
					<th style="text-align: center">Instagram URL</th>														
					<th style="text-align: center">Added On</th>															
					<th style="text-align: center" colspan="2">Actions</th>					
				</tr>
				</thead>
				<tbody>					
					@forelse($djs as $dj)
					<tr style="text-align: center">
						<td width="65"><img width="50px" class="img-responsive" style="border-radius: 50px;" src="{{config('app.url')}}/core/public/storage/uploads/{{$dj->image}}"></td>						
						<td>{{$dj->name}}</td>
						<td><a href="{{$dj->insta_url}}" target="_blank"></a>{{$dj->insta_url}}</td>
						<td>{{$dj->created_at->toFormattedDateString()}}</td>												
						<td width="5"><a href="{{route('english.dj.edit',['id'=>$dj->feature_dj_id])}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a></td>

						<td width="5">
							<a href="#" class="btn btn-danger btn-sm"
										data-toggle="modal"
										data-target=".bd-example-modal-sm{{$dj->feature_dj_id}}">
								<i class="fa fa-trash-o"></i>
							</a>

							<div class="modal fade bd-example-modal-sm{{$dj->feature_dj_id}}"
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
									<p>	Are you sure you want to delete <strong>"{{$dj->name}}"</strong>. </p>
										<p><strong style="color: red"> Warning! </strong>This will also remove the <strong>image banner</strong> from this server.</p>
									</div>
									<div class="modal-footer">	
										<form action="{{route('english.dj.delete',['id'=>$dj->feature_dj_id])}}" method="POST">										
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
						<td colspan="10">No songs available.</td>
					</tr>
					@endforelse
				</tbody>
			</table>
			<div class="custom-paginate">
			{{$djs->links()}}	
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