@extends('layout.main')

@section('content')
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>VIP List</h3>				
				<small class="text-muted custom-alignment">List of VIP people who have signed up a form from the mobile apps.</small>
			</div>					
		</div>
	</div>
	<table id="table-edit" class="table table-bordered table-hover">
				<thead>
				<tr>	
					<th style="text-align: center">Name</th>				
					<th style="text-align: center">Business Name</th>	
					<th style="text-align: center">Business Address</th>					
					<th style="text-align: center">Business Type</th>
					<th style="text-align: center">Mobile No</th>
					<th style="text-align: center">Office No</th>
					<th style="text-align: center">Email</th>
					<th style="text-align: center">Birthdate</th>
					<th style="text-align: center">Description</th>					
				</tr>
				</thead>
				<tbody>					
					@forelse($vips as $vip)
					<tr style="text-align: center">						
						<td>{{$vip->fname}} {{$vip->lname}}</td>
						<td>{{$vip->b_name}}</td>
						<td>{{$vip->b_address}}</td>
						<td>{{$vip->b_type}}</td>
						<td>{{$vip->mob_no}}</td>
						<td>{{$vip->office}}</td>
						<td>{{$vip->email}}</td>
						<td>{{$vip->bdate}}</td>
						<td>{{$vip->description}}</td>
					</tr>
					@empty
					<tr>
						<td colspan="10">No vip list members found.</td>
					</tr>
					@endforelse
				</tbody>
			</table>
			<div class="custom-paginate">
			{{$vips->links()}}	
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