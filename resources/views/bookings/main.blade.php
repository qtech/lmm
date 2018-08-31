@extends('layout.main')

@section('content')
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>Booking Details List</h3>				
				<small class="text-muted custom-alignment">List of all the bookings you have recieved so far, with the latest one at the very beginning.</small>
			</div>					
		</div>
	</div>
	<table id="table-edit" class="table table-bordered table-hover">
				<thead>
				<tr>	
					<th style="text-align: center">Name</th>
					<th style="text-align: center">Artist Name</th>
					<th style="text-align: center">Mobile No</th>
					<th style="text-align: center">Email</th>
					<th style="text-align: center">Booking Date</th>
					<th style="text-align: center">Booking Time</th>									
					<th style="text-align: center">Booking Address</th>					
					<th style="text-align: center">City</th>
					<th style="text-align: center">State</th>
					<th style="text-align: center">Country</th>
					<th style="text-align: center">Zipcode</th>
					<th style="text-align: center">Party Type</th>
					<th style="text-align: center">User Id</th>					
				</tr>
				</thead>
				<tbody>					
					@forelse($bookings as $booking)
					<tr style="text-align: center">						
						<td>{{$booking->name}}</td>
						<td>{{$booking->artist_name}}</td>
						<td>{{$booking->mob_no}}</td>
						<td>{{$booking->email}}</td>
						<td>{{$booking->date}}</td>
						<td>{{$booking->time}}</td>
						<td>{{$booking->address}}</td>
						<td>{{$booking->city}}</td>
						<td>{{$booking->state}}</td>
						<td>{{$booking->country}}</td>
						<td>{{$booking->zip}}</td>
						<td>{{$booking->party_type}}</td>
						<td>{{$booking->user_id}}</td>
					</tr>
					@empty
					<tr>
						<td colspan="12">No vip list members found.</td>
					</tr>
					@endforelse
				</tbody>
			</table>

			<div class="custom-paginate">
			{{$bookings->links()}}	
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
