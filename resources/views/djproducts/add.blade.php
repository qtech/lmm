@extends('layout.main')

@section('content')

<div class="tbl">
	<div class="tbl-row">
		<div class="tbl-cell">
			<h3>Add New DJ Product</h3>
			<small class="text-muted custom-alignment">Please add relevant product information.</small>
		</div>		
		<div class="tbl-cell tbl-cell-action">
			<a href="{{route('djproducts.index')}}" class="btn btn-secondary pull-right"><i class="fa fa-hand-o-left"></i> Back</a>
		</div>
	</div>
</div>

<div class="box-typical box-typical-padding">
	<form action="{{route('djproducts.store')}}" method="POST" enctype="multipart/form-data">
	{{csrf_field()}}	
	
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Product Name</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="text" class="form-control maxlength-simple" id="product_name" name="product_name" placeholder="Product Name" maxlength="50" value="{{old('album_name')}}">
			<small class="text-muted">Max length 50</small></p>
		</div>
    </div>
    
    <div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Product Price</label>
		<div class="col-sm-9">
			<p class="form-control-static"><input type="number" class="form-control maxlength-simple" id="product_price" name="product_price" placeholder="Product Price" maxlength="50" value="{{old('album_name')}}">
			<small class="text-muted">Please add price for the product</small></p>
		</div>
	</div>
	
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms">Product Image</label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<input type="file" class="form-control" id="product_image" name="product_image">
				<small class="text-muted">This image will be used as a banner for this product.</small></p>
			</p>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-3 form-control-label ajdust-label-forms"></label>
		<div class="col-sm-9">
			<p class="form-control-static">
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save </button>
				<a href="{{route('djproducts.index')}}" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Cancel</a>
			</p>
		</div>
	</div>
	</form>
</div>

@endsection