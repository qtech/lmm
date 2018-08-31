@extends('layout.main')

@section('content')
	<div class="tbl">
		<div class="tbl-row">
			<div class="tbl-cell">
				<h3>DJ Products</h3>				
				<small class="text-muted custom-alignment">List of Products.</small>
			</div>	
			<div class="tbl-cell tbl-cell-action">
				<a href="{{route('djproducts.add')}}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add Product</a>
			</div>	
		</div>
	</div>
	<table id="table-edit" class="table table-bordered table-hover">
				<thead>
				<tr>	
					<th style="text-align: center">Image</th>				
					<th style="text-align: center">Product Name</th>		
					<th style="text-align: center">Price</th>
					<th style="text-align: center" colspan="2">Actions</th>					
				</tr>
				</thead>
				<tbody>					
					@forelse($products as $product)
					<tr style="text-align: center">
						<td width="65"><img width="50px" class="img-responsive" style="border-radius: 50px;" src="{{asset(getenv('IMG_VIEW').$product->product_image)}}"></td>
						<td>{{$product->product_name}}</td>
						<td>${{$product->product_price}}</td>						
						<td width="5"><a href="{{route('djproducts.edit',['id'=>$product->product_id])}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a></td>

						<td width="5">
							<a href="#" class="btn btn-danger btn-sm"
										data-toggle="modal"
										data-target=".bd-example-modal-sm{{$product->product_id}}">
								<i class="fa fa-trash-o"></i>
							</a>

							<div class="modal fade bd-example-modal-sm{{$product->product_id}}"
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
									<p>	Are you sure you want to delete <strong>"{{$product->product_name}}"</strong> ? </p>
										<p><strong style="color: red"> Warning! </strong>This will also remove the <strong>image</strong> from this server.</p>
									</div>
									<div class="modal-footer">	
										<form action="{{route('djproducts.delete',['id'=>$product->product_id])}}" method="POST">										
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
						<td colspan="8">No DJ Products found. Please add some products.</td>
					</tr>
					@endforelse
				</tbody>
			</table>
			<div class="custom-paginate">
			{{$products->links()}}	
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