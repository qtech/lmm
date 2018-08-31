@extends('layout.main')

@section('content')

<div class="tbl">
	<div class="tbl-row">
		<div class="tbl-cell">
			<h3>Add an Event</h3>
			<small class="text-muted custom-alignment">Add the information of event accurately. It will be displayed in the app with the information.</small>
		</div>		
		<div class="tbl-cell tbl-cell-action">
			<a href="{{route('events.index')}}" class="btn btn-secondary pull-right"><i class="fa fa-hand-o-left"></i> Back</a>
		</div>
	</div>
</div>

<div class="box-typical box-typical-padding">
	<form action="{{route('events.store')}}" method="POST" enctype="multipart/form-data">
	{{csrf_field()}}	
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Event Title</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="event_title" name="event_title" placeholder="Event Title" maxlength="150" value="{{old('event_title')}}">
			<small class="text-muted">Max length 150 -  "Give your event an attractive title."</small></p>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Description</label>
		<div class="col-sm-9">
			<p class="form-control-static"><textarea id="new_event" name="description" class="form-control">{{old('description')}}</textarea>
			</p>
		</div>
	</div>	
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Start/End Date</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" name="daterange" class="form-control" value="{{old('daterange')}}" />
			<small class="text-muted">The starting and ending date of the event.</small></p>
		</div>
	</div>	
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Event Start Time</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="event_time" name="event_time" placeholder="Event Start Time" maxlength="10" value="{{old('event_time')}}">
			<small class="text-muted">Max length 10 - Enter the time at which this event will start.</small></p>
		</div>
	</div>
		
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Event Address</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="event_address" name="address" placeholder="Event Address" maxlength="255" value="{{old('address')}}">
			<small class="text-muted">Max length 255 -  "Add an accurate address to this event." For Ex :  "448 N 17th St Allentown, Pennsylvania, PA 18104"</small></p>
		</div>
	</div>
	
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Event Image/Banner</label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<input type="file" class="form-control" id="image" name="image">
				<small class="text-muted">This image will be used as a banner/thumbnail for this event.</small></p>
			</p>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms"></label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save </button>
				<a href="{{route('events.index')}}" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
			</p>
		</div>
	</div>
	</form>
</div>

@endsection