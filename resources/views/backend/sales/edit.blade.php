@extends('backendtemplate')

@section('content')
	<h1 class="text-center font-weight-bold"><u>Edit Sale Form <span class="text-primary">({{ $sale->b_short }} - {{ $sale->voucher_no }})</span></u></h1>

	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">
				<a href=" {{ route('sale_branch',$sale->branch_id) }} " class="btn btn-outline-warning">Back</a>
			</div>
		</div>
	</div>
	<form method="post" action="{{route('sales.update',$sale->id)}}" class="form-group">
		@csrf
		@method('PUT')

		<div class="container">
			<div class="row">
				<div class="col-md-6 col-lg-6">
						
					<label class="font-weight-bold">Choose Customer</label>
					<select name="customer_name" id="customer_name" class="form-control @error ('customer_name') @enderror">
						<option value="">--- Choose Customer---</option>
						@foreach($customers as $customer)
							
							<option value="{{$customer->id}}" @if($sale->customer_id == $customer->id) selected="selected" @endif>{{$customer->name}}</option>
						@endforeach
					</select>
					@error('customer_name')
						<div class="alert alert-danger">{{ $message }}</div>
					@enderror

				</div>

				<div class="col-md-6 col-lg-6">

					<label class="font-weight-bold d-block">Sale Date</label>
						
							<input type="date" name="date" id="date" class="form-control @error('date') @enderror" value="{{ $sale->saledate }}">
						
						@error('date')
							<div class="alert alert-danger">{{ $message }}</div>
						@enderror

				</div>

			</div>

			<div class="row my-2">
				
				<div class="col-md-4 col-sm-4 col-lg-4">
					<label class="font-weight-bold">Sale Mehtod</label>
					
					<select name="sale_method" id="sale_method" class="form-control @error ('sale_method') @enderror">
						
						<option value="cash" selected="selected">Cash Down Payment</option>
						<option value="credit">1 Month Credit Payment</option>
						
						<option value="1week">1 Week Credit Payment</option>
						<option value="2week">2 Week Credit Payment</option>
						
					</select>
					@error('sale_method')
						<div class="alert alert-danger">{{ $message }}</div>
					@enderror
				</div>

				<div class="col-md-4 col-sm-4 col-lg-4">
					<label class="font-weight-bold d-block">Bonus Amount</label>
						
					<input type="number" name="bonus" class="form-control" min="0" placeholder="Enter Bonus" value="{{$sale->bonus}}">
				</div>

				<div class="col-md-4 col-sm-4 col-lg-4">
					<label class="font-weight-bold d-block">Discount Amount</label>
						
					<input type="number" name="discount" class="form-control" min="0" max="100" placeholder="Enter Percentage" value="{{$sale->discount}}">
				</div>
				
			</div>

		</div>

		<!-- container for sale table records -->
		<div class="container mt-4">
			<div class="row">
				<div class="col-md-12 col-lg-12 table-responsive">
					<table class="table table-hover table-dark text-center">
						<thead>
							<tr>
								<th colspan="5" class="text-center">
									Sold Items
								</th>
							</tr>
							<th>No</th>
							<th>Branch Name</th>
							<th>Product Name</th>
							<th>Return Quantity</th>
							<th>Qauntity</th>
							<th>Action</th>
						</thead>
						<tbody>
							@php $i=1 @endphp
							@foreach($saledetail as $detail)
								<tr>
									<td>
										{{$i}}
									</td>
									<td>
										{{$detail->sale->branch->name}}
									</td>
									<td>
										{{$detail->product->name}}
										<input type="hidden" name="product_id{{$i}}" value="{{$detail->product_id}}">
									</td>
									<td>
										@if(isset($detail->sale_return))
											{{$detail->sale_return}}
											@else
											-
										@endif
									</td>
									<td>
										@if(isset($detail->sale_return))
											@php $min = $detail->sale_return; @endphp
											@else
											@php $min = 0; @endphp
										@endif
										@foreach($stocks as $check_stock) 
											@if($detail->product_id == $check_stock->product_id)
												
											
											<input type="number" name="quantity{{$i}}" value="{{$detail->quantity}}" class="form-control" min="{{$min}}" max="{{$detail->quantity + $check_stock->quantity}}">
										
											@endif
										@endforeach
									</td>
									<td>
										<input class="form-check-input check" type="checkbox" name="delete{{$i}}" id="{{$i}}" value="Delete">
										<label class="form-check-label" for="{{$i}}">Delete</label>
										<span style="display: none;">{{$i++}}</span>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		
		<!-- button for showing new products -->
			<input type="button" name="moreproducts" class="btn btn-outline-primary" value="Add more Products">

		
				<div class="col-md-12 col-lg-12 mt-4 table-responsive" id="product_table" style="display: none;">

					<table id="data" class="table table-striped table-bordered">
						<thead>
							
							<tr>
								<th>No</th>
								<th>Product Name</th>
								<th>Subcategory</th>
								<th>Current Quantity</th>
								<th>Sale Amount</th>
							</tr>
						</thead>
						<tbody>
							<?php $j=1; ?>
							@foreach($stock_arr as $rows)
							
								
									
									<tr>
									<td>{{$j}}</td>
									<td>{{$rows->product->name}}</td>
									<td>
										@foreach($product as $row)
											@if($rows->product_id == $row->id)
												{{$row->subcategory->name}}
											@endif
										@endforeach
									</td>
									<td>{{$rows->quantity}}</td>
									<td>
										<input type="hidden" name="add_product_id{{$j}}" value="{{$rows->product_id}}">
										<input class="form-control quantity" type="number" name="add_quantity{{$j}}" min="0" max="{{$rows->quantity}}">
									</td>
									<span style="display: none;">{{$j++}}</span>
								</tr>
								
									


								
							@endforeach
						</tbody>
					</table>

				</div>
			
			
		</div>

		@if(count($promotiondetail) > 0)
		@php $i=1; @endphp
			<div class="container mt-4">
				<div class="row">
					<div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
						<table class="table table-hover table-bordered table-dark text-center">
							<thead>
								<tr>
									<td colspan="4" class="text-center">
										Promotion Items
									</td>
								</tr>
								<tr>
									<th>No</th>
									<th>Product Name</th>
									<th>Quantity</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($promotiondetail as $promo)
									<tr>
										<td>
											{{$i}}
										</td>
										<td>
											{{$promo->product->name}}
											<input type="hidden" name="promo_product_id{{$i}}" value="{{$promo->product_id}}">
										</td>
										<td>
											<input type="text" name="promo_quantity{{$i}}" value="{{$promo->quantity}}" class="form-control">
										</td>
										<td class="text-center">
											<input class="form-check-input check" type="checkbox" name="promo_delete{{$i}}" id="promo_{{$i}}" value="Delete">
											<label class="form-check-label" for="promo_{{$i++}}">Delete</label>
											
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>

				<input type="button" name="more_promo" class="btn btn-outline-primary" value="Add more Promotion Products">

				<div class="row my-3">
					<div class="col-md-12 col-lg-12 col-sm-12 table-responsive" id="promo_product" style="display: none;">
						<table id="promo_data" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>No</th>
									<th>Product Name</th>
									<th>Quantity</th>
								</tr>
							</thead>
							<tbody>
								@php $i=1; @endphp
								@foreach($promo_arr as $row)
									<tr>
										<td>
											{{$i}}
										</td>
										<td>
											{{$row->product->name}}
										</td>
										<td>
											<input type="hidden" name="add_promo_id{{$i}}" value="{{$row->product_id}}">
											<input class="form-control quantity" type="number" name="add_promo_quantity{{$i++}}" min="0" max="{{$row->quantity}}">
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>

			</div>
			@elseif(count($promotiondetail) == 0 && $promotion != Null)
				<div class="container">
					<div class="col-md-12 col-lg-12 col-sm-12 text-center">
						<h3><u>Promotion Products</u></h3>
					</div>
					<div class="row my-3">
					<div class="col-md-12 col-lg-12 col-sm-12 table-responsive" id="promo_product">
						<table id="dataTable" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>No</th>
									<th>Product Name</th>
									<th>Quantity</th>
								</tr>
							</thead>
							<tbody>
								@php $i=1; @endphp
								@foreach($stocks as $row)
									<tr>
										<td>
											{{$i}}
										</td>
										<td>
											{{$row->product->name}}
										</td>
										<td>
											<input type="hidden" name="add_promo_id{{$i}}" value="{{$row->product_id}}">
											<input class="form-control quantity" type="number" name="add_promo_quantity{{$i++}}" min="0" max="{{$row->quantity}}">
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				</div>

		@endif

		
		<input type="submit" class="btn btn-success float-right mr-3" value="Save">
	</form>

@endsection

@section('script')

	<script type="text/javascript">
		
		$(document).ready(function() {
			
			$('#data').dataTable();
			$('#promo_data').dataTable();

			$('input[name=moreproducts]').on('click', function(event) {
				
				$('#product_table').toggle();

			});

			$('input[name=more_promo]').on('click', function(event) {
				
				$('#promo_product').toggle();

			});

			$('.quantity').on('input',function(){
				
				if ($(this).val().length > 0) {
					$(this,".color").parent().parent().css({"background-color":"red","color":"white"});
					// $(':input[type="submit"]').prop('disabled', false);
				}else{
					$(this,".color").parent().parent().css({"background-color":"white","color":"grey"});
					// $(':input[type="submit"]').prop('disabled', true);
				}
			});

		});


	</script>

@endsection