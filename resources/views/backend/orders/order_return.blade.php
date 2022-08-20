@extends('backendtemplate')

@section('content')

	<h1 class="text-center font-weight-bold text-danger">Order Return Form</h1>

	<form class="form-group" method="post" action="{{route('order_return_update',$order->id)}}">
		@csrf
		@method('PUT')
		<div class="container-fluid border-dark mt-4">
			<div class="row">
				<div class="col-md-12 col-lg-12 col-sm-12 my-2">
					<a href="{{route('orders.index')}}" class="btn btn-outline-warning float-left">Back</a>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-4 text-center">
					<div class="card">
					  <div class="card-body">
					    <h5 class="card-title">Customer Name</h5><hr>
					    <p class="card-text">{{$order->suppliername}}</p>
					  </div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 text-center">

					<div class="card">
					  <div class="card-body">
					    <h5 class="card-title">Order Date</h5><hr>
					    <p class="card-text">{{$order->orderdate}}</p>
					  </div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 text-center">

					<div class="card">
					  <div class="card-body">
					    <h5 class="card-title">Return Date</h5><hr>
					    <p class="card-text"><input type="date" name="return_date" class="mb-3 form-control @error('return_date') @enderror"></p>
					  </div>
					</div>
					
					@error('return_date')
						<div class="alert alert-danger">{{ $message }}</div>
					@enderror
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 col-lg-12 table-responsive">
							@php $i=1; @endphp
							@foreach($branches as $rows)
								<h1 class="text-center font-weight-bold">{{$rows->branch->name}}</h1>
								
								
								<table class="table table-hover table-dark">
								<thead>
									<tr class="text-center">
										<td>No</td>
										<td>Product Name</td>
										<td>Quantity</td>
										<td>Return Quantity</td>
									</tr>
								</thead>
								<tbody>
								
								@foreach($orderdetails as $orderdetail)
									@if($rows->branch_id == $orderdetail->branch_id)
										<tr class="text-center checkrow">
											<td scope="row">{{$i}}</td>
											<td>

												<input type="hidden" name="product_id{{$i}}" value="{{$orderdetail->product_id}}">

												{{$orderdetail->product->name}}
											</td>
											<td>

												{{$orderdetail->quantity}}

											</td>
											<td>

												<input type="hidden" name="branch{{$i}}" value="{{$rows->branch_id}}">
												
												
												<input class="form-control" type="number" name="return_quantity{{$i++}}" min="0" max="{{$orderdetail->quantity}}">
												
												
											</td>
										</tr>
									@endif
								@endforeach
								</tbody>
								</table>
								<hr>
							@endforeach

							
						
				</div>
			</div>
			<input type="submit" name="Return" class="btn btn-success float-right">
		</div>

		

	</form>

@endsection

@section('script')

@endsection