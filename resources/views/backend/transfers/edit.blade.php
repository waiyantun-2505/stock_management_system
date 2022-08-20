@extends('backendtemplate')

@section('content')
	
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 text-center">
				<h1><u>Transfer Edit</u></h1>
			</div>
			<div class="col-md-12 col-lg-12 col-sm-12">
				<a href="{{route('transfers.index')}}" class="btn btn-outline-warning">Back</a>
			</div>

		</div>

		<form action="{{route('transfers.update',$transfer->id)}}" method="post">
			@csrf
			@method('PUT')

			<div class="row my-2">

				<div class="col-md-4 col-sm-4 col-lg-4">
					<div class="card text-center">
					  <div class="card-body">
					    <h5 class="card-title">From Branch</h5><hr>
					    <p class="card-text">
					    	@foreach($branches as $branch)
							@if($branch->id == $transfer->from_branch)
								{{$branch->name}}
							@endif
						@endforeach
					    </p>
					  </div>
					</div>
				</div>
				
				<div class="col-md-4 col-sm-4 col-lg-4">
					<div class="card text-center">
					  <div class="card-body">
					    <h5 class="card-title">To Branch</h5><hr>
					    <p class="card-text">
					    	@foreach($branches as $branch)
							@if($branch->id == $transfer->to_branch)
								{{$branch->name}}
							@endif
						@endforeach
					    </p>
					  </div>
					</div>
				</div>

				<div class="col-md-4 col-sm-4 col-lg-4">
					<div class="card text-center">
					  <div class="card-body">
					    <h5 class="card-title">Transfer Date</h5><hr>
					    <p class="card-text">
					    	<input type="date" name="date" class="form-control position-sticky" value="{{$transfer->transfer_date}}">
					    </p>
					  </div>
					</div>
				</div>

					 
				
			</div>

			<div class="row my-3">
				<div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
					<table class="table table-bordered table-hover table-dark">
						<thead>
							<tr>
								<td>No</td>
								<td>Product Name</td>
								<td>Quantity</td>
								<td>Action</td>
							</tr>
						</thead>
						<tbody>
							@php 
								$i=1;
							@endphp
							@foreach($transferdetail as $detail)
								<tr>
									<td>
										{{$i}}
									</td>

									<td>
										{{$detail->product->name}}
										<input type="hidden" name="old_product_id{{$i}}" value="{{$detail->product_id}}">
									</td>

									<td>
										@foreach($stocks as $stock)
											@if($stock->product_id == $detail->product_id)
												
												@php
												$max = $stock->quantity + $detail->quantity;
												@endphp
											
										<input type="number" name="old_quantity{{$i}}" value="{{$detail->quantity}}" class="form-control" min="0" max="{{$max}}">
											@endif
										@endforeach
									</td>

									<td class="text-center">

										<input class="form-check-input check" type="checkbox" name="delete{{$i}}" id="{{$i}}" value="Delete">
										<label class="form-check-label" for="{{$i++}}">Delete</label>

									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			
				
		</div>
			
			<div class="row">
				 <div class="col-md-12 col-lg-12 col-sm-12">
				 	<!-- button for showing new products -->
				<input type="button" name="moreproducts" class="btn btn-outline-primary" value="Add more Products">
			

				<div class="col-lg-12 col-md-12 col-sm-12 table-responsive mt-4" id="product_table" >
				<table id="dataTable" class="table table-bordered table-hover">
					<thead>
						<tr>
							<td>No</td>
							<td>Product Name</td>
							<td>Current Quantity</td>
							<td>Quantity</td>
						</tr>
					</thead>
					<tbody>
						@php
							$j=1;
						@endphp
						@foreach($new_stocks as $new)
							<tr>
								<td>{{$j}}</td>
								<td>
									{{$new->product->name}}
									<input type="hidden" name="new_product{{$j}}" value="{{$new->product_id}}">
								</td>
								<td>{{$new->quantity}}</td>
								<td>
									<input type="number" name="new_quantity{{$j++}}" class="form-control">
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<input type="submit" class="btn btn-success float-right" value="Save">
				 </div>
			</div>
			
				

		</form>

	</div>

@endsection

@section('script')
	
	<script type="text/javascript">
		
		$(function() {
			$('#product_table').css('display','none');

			$('input[name=moreproducts]').on('click', function(event) {
				
				$('#product_table').toggle();

			});
		});

	</script>

@endsection