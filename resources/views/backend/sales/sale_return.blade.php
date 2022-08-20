@extends('backendtemplate')

@section('content')
	
	<h1 class="text-center font-weight-bold text-danger">Sale Return Form</h1>

	<form class="form-group" method="post" action="{{route('sale_update',$sale->id)}}">
		@csrf
		@method('PUT')
		<div class="container-fluid border-dark mt-4">
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-3 text-center">
					<!-- <label class="h2">Customer Name</label> -->
					<h2 class="font-weight-bold">Branch Name</h2>
					<label class="h4">{{$sale->branch->name}}</label>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 text-center">
					<!-- <label class="h2">Customer Name</label> -->
					<h2 class="font-weight-bold">Customer Name</h2>
					<label class="h4">{{$sale->customer->name}}</label>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 text-center">
					<!-- <label class="h2">Order Date</label> -->
					<h2 class="font-weight-bold">Sale Date</h2>
					<label class="h4">{{$sale->saledate}}</label>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 text-center">
					<h2 class="font-weight-bold">Return Date</h2>
					
					<input type="date" name="return_date" class="mb-3 form-control @error('return_date') @enderror">
					
					@error('return_date')
						<div class="alert alert-danger">{{ $message }}</div>
					@enderror
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-lg-12 table-responsive">
				
				<table class="table table-hover table-dark text-center">
					<thead>
						<tr>
							<th>No</th>
							<th>Product Name</th>
							<th>Qauntity</th>
							<th>Returned Quantity</th>
							<th>Return Quantity</th>
						</tr>
						
					</thead>
					<tbody>
						@php $i=1; @endphp
						@foreach($saledetail as $detail)
							<tr>
								<td>{{$i}}</td>
								<td>{{$detail->product->name}}</td>
								<td>{{$detail->quantity}}</td>
								@if($detail->sale_return == null)
									<td>-</td>
									@php $total = $detail->quantity; @endphp
									
								@else
									<td>{{$detail->sale_return}}</td>
									@php $total = $detail->quantity - $detail->sale_return; @endphp

								@endif
								<td>

									<input type="hidden" name="product_id{{$i}}" value="{{$detail->product->id}}">
									<input type="number" name="return_quantity{{$i++}}" class="form-control" min="0" max="{{$total}}">

								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				</div>
			</div>
			<input type="submit" name="Save" class="btn btn-primary">
		</div>
	</form>

@endsection

@section('script')

@endsection