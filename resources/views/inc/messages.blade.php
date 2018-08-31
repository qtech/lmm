@if(count($errors)>0)
	@foreach($errors->all() as $error)
		<div class="alert alert-danger alert-icon alert-close alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
			<i class="font-icon font-icon-warning"></i> <strong>Error!</strong> {{$error}}
		</div>
	@endforeach
@endif

@if(session('success'))
	<div class="alert alert-success alert-icon alert-close alert-dismissible fade in" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">×</span>
		</button>
		<i class="font-icon font-icon-warning"></i> <strong>Success!</strong> {{session('success')}}
	</div>
@endif


@if(session('error'))
	<div class="alert alert-danger alert-icon alert-close alert-dismissible fade in" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">×</span>
		</button>
		<i class="font-icon font-icon-warning"></i> <strong>Error!</strong> {{session('error')}}
	</div>
@endif