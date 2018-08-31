@extends('layout.main')

@section('content')
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>Social Links</h3>				
				<small class="text-muted custom-alignment">List of social links.</small>
			</div>					
		</div>
	</div>
	<table id="table-edit" class="table table-bordered table-hover">
				<thead>
				<tr>	
					<th style="text-align: center">Social Name</th>				
					<th style="text-align: center">Social Link</th>										
					<th style="text-align: center">Actions</th>					
				</tr>
				</thead>
				<tbody>					
					@forelse($socials as $social)
					<tr style="text-align: center">						
						<td>{{$social->social_name}}</td>
						<td>{{$social->social_link}}</td>						
						<td width="5"><a href="{{route('socials.edit',['id'=>$social->social_id])}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a></td>
					</tr>
					@empty
					<tr>
						<td colspan="4">No Social Links found.</td>
					</tr>
					@endforelse
				</tbody>
			</table>

@endsection