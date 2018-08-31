@extends('layout.main')

@section('content')
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>Notifications</h3>				
				<small class="text-muted custom-alignment">List of notifications sent till date.</small>
			</div>	
			<div class="tbl-cell tbl-cell-action">
				<a href="{{route('notifications.send')}}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> New Notification</a>
			</div>				
		</div>		
	</div>
	<table id="table-edit" class="table table-bordered table-hover">
				<thead>
				<tr>	
					<th style="text-align: center">Notification Message</th>				
					<th style="text-align: center">Sent On</th>										
					<th style="text-align: center">Actions</th>					
				</tr>
				</thead>
				<tbody>					
					@forelse($notifications as $notification)
					<tr style="text-align: center">						
						<td>{{$notification->message}}</td>
						<td>{{$notification->created_at}}</td>
						<td width="5">
							<a href="#" class="btn btn-danger btn-sm"
										data-toggle="modal"
										data-target=".bd-example-modal-sm{{$notification->notification_id}}">
								<i class="fa fa-trash-o"></i>
							</a>

							<div class="modal fade bd-example-modal-sm{{$notification->notification_id}}"
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
									<p>	Are you sure you want to delete this notification? </p>
									</div>
									<div class="modal-footer">	
										<form action="{{route('notifications.delete',['id'=>$notification->notification_id])}}" method="POST">	
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
						<td colspan="4">No Notifications found. Please send some notifications</td>
					</tr>
					@endforelse
				</tbody>
			</table>
			<div class="custom-paginate">
			{{$notifications->links()}}	
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