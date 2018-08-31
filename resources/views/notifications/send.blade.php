@extends('layout.main')

@section('content')

<div class="tbl">
	<div class="tbl-row">
		<div class="tbl-cell">
			<h3>New Notification</h3>
			<small class="text-muted custom-alignment">Send new notification to all the users.</small>
		</div>		
		<div class="tbl-cell tbl-cell-action">
			<a href="{{route('notifications.index')}}" class="btn btn-secondary pull-right"><i class="fa fa-hand-o-left"></i> Back</a>
		</div>
	</div>
</div>

<div class="box-typical box-typical-padding">
	<form action="{{route('notifications.store')}}" method="POST" enctype="multipart/form-data">
	{{csrf_field()}}	
	
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Notifications Message</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="message" name="message" placeholder="Notifications Message" maxlength="255" value="{{old('message')}}">
			<small class="text-muted">Max length 255 - "Make notifications short and meaningful."</small></p>
		</div>
	</div>	
	
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms"></label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save </button>
				<a href="{{route('notifications.index')}}" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
			</p>
		</div>
	</div>
	</form>
</div>

@endsection