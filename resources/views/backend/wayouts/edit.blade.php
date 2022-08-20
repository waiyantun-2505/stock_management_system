@extends('backendtemplate')

@section('content')
	
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 text-center text-info">
				<h1>Edit Wayout</h1>
			</div>
		</div>
		
		<form action="{{route('wayouts.update',$wayout->id)}}" method="post" >
			@csrf
			@method('PUT')
			<div class="row">

				<div class="col-lg-4 col-md-4">
					<label for="city">Way Citites</label>
					
					<input type="text" id="city" name="city" class="form-control @error('city') @enderror" value="{{$wayout->way_cities}}">	
					
					@error('city')
						<div class="alert alert-danger">{{ $message }}</div>
					@enderror	
				</div>

				<!-- From Branch -->
				<div class="col-lg-4 col-md-4">
					<label for="branchname1">From Branch</label>
					<input type="date" name="date" class="form-control @error ('date') @enderror" value="{{$wayout->wayout_date}}">
					@error('date')
						<div class="alert alert-danger">{{ $message }}</div>
					@enderror
				</div>

				<!-- To Branch -->
				<div class="col-lg-4 col-md-4">
					<label for="branch_id">Way Out Branch</label>
					<select id="branch_id" name="branch_id" class="select form-control @error ('branch_id') @enderror" onmousedown="if(this.options.length>3){this.size=3;}"  onchange='this.size=0;' onblur="this.size=0;" searchable="Search here..">
						

						
							<option value="{{$wayout->branch_id}}">{{$wayout->branch->name}}</option>
						
					</select>
					@error('branch_id')
						<div class="alert alert-danger">{{ $message }}</div>
					@enderror
				</div>

			</div>
			

			<div class="row mt-3">
				<div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
					<table class="table table-bordered table-dark table-hover text-center">
						<thead>
							<tr>
								<th>No</th>
								<th>Product Name</th>
								<th>Current Stocks</th>
								<th>Way Stocks</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@php $i=1; @endphp
							@foreach($wayout_detail as $detail)
								<tr>
									<td>{{$i}}</td>
									<td>{{$detail->product->name}}</td>

										@foreach($stocks as $stock)
											@if($stock->product_id == $detail->product_id)
												<td>
													{{$stock->quantity}}
												</td>
											
												<td>
													<input type="hidden" name="product_id{{$i}}" value="{{$detail->product_id}}">
													<input type="number" name="quantity{{$i}}" class="form-control" value="{{$detail->quantity}}" min="0" max="{{$detail->quantity + $stock->quantity}}">
												</td>
											@endif
										@endforeach

									<td>
										<input class="form-check-input check" type="checkbox" name="delete{{$i}}" id="{{$i}}" value="Delete">
										<label class="form-check-label" for="{{$i++}}">Delete</label>
										
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

					<table id="dataTable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>No</th>
								<th>Product Name</th>
								<th>Current Stocks</th>
								<th>Way Stocks</th>
							</tr>
						</thead>
						<tbody>
							<?php $j=1; ?>
							@foreach($stock_arr as $rows)
							
								
									
									<tr>
									<td>{{$j}}</td>
									<td>{{$rows->product->name}}</td>
									<td>
										{{$rows->quantity}}
									</td>
									
									<td>
										<input type="hidden" name="add_product_id{{$j}}" value="{{$rows->product_id}}">
										<input class="form-control quantity" type="number" name="add_quantity{{$j++}}" min="0" max="{{$rows->quantity}}">
									</td>
									
								</tr>
								
									


								
							@endforeach
						</tbody>
					</table>

				</div>
			
			<input type="submit" class="btn btn-primary ml-5" value="Save">

		</form>

	</div>
	
@endsection

@section('script')
	
	<script type="text/javascript">
		$(document).ready(function() {
			
			$('input[name=moreproducts]').on('click', function(event) {
				
				$('#product_table').toggle();

			});
		});
	</script>

@endsection