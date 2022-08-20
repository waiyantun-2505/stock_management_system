@extends('backendtemplate')

@section('content')

	<div class="container">
		<ul class="list-group shadow">
			<li class="list-group-item">
				<div class="row">
					<div class="col-md-12 col-lg-12 col-sm-12 text-center">
						<h1><u>Add Product From (<span class="text-primary">{{ $branch->name }}</span>)</u></h1>
					</div>

					<div class="col-md-12 col-lg-12 col-sm-12">
						<a href=" {{route('waysales.index')}} " class="btn btn-warning">Back</a>
					</div>

					<!-- Wayout Stock -->

					<div class="col-md-12 col-lg-12 col-sm-12 table-responsive my-3">
						<table class="table table-hover table-bordered text-center">
							<thead>
								<tr>
									<th colspan="4" class="bg-success text-white">Wayout Items</th>
								</tr>
								<tr>
									<th>No</th>
									<th>Product Name</th>
									<th>Remaining Quantity</th>
									<th>Sold Quantity</th>
								</tr>
							</thead>
							<tbody>
								@php $i=1; @endphp
								@foreach($wayoutstocks->wayoutdetails as $stock)
									<tr>
										<td> {{ $i++ }} </td>
										<td> {{ $stock->product->name }} </td>
										<td> 
											@php
												$remain = $stock->quantity - $stock->sale_quantity;
											@endphp
											{{ $remain }}
										</td>
										<td> @if($stock->sale_quantity == Null)  - @else {{ $stock->sale_quantity }} @endif </td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>

					<!-- Stock table -->

					<div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
						<form action=" {{ route('wayadd_store',$wayoutstocks->id) }} " method="post">
							@csrf
							<table id="dataTable" class="table table-hover table-bordered text-center"> 
							<thead class="bg-primary text-white">
								<tr>
									<th>No</th>
									<th>Product Name</th>
									<th>Remaining Quantity</th>
									<th>Add Quantity</th>
								</tr>
							</thead>
							<tbody>
								@if(count($stocks) > 0)

									@php $i = 1; @endphp

									@foreach($stocks as $stock)

										<tr>
											<td> {{ $i }} </td>
											<td> {{ $stock->product->name }} </td>
											<td> {{ $stock->quantity }} </td>
											<td>
												<input type="hidden" value="{{$stock->product_id}}" name="add_product_id{{$i}}">
												<input type="number" name="add_quantity{{$i++}}" min="0" max="{{$stock->quantity}}" class="quantity form-control"> 
											</td>
										</tr>

									@endforeach

								@else

								@endif
							</tbody>
						</table>
						<input type="hidden" name="branch_id" value="{{$branch->id}}">
						<input type="submit" value="Add To Way" class="btn btn-success float-right my-4">

						</form>
					</div>

				</div>
			</li>
		</ul>
	</div>

@endsection

@section('script')
	
	<script type="text/javascript">


		var mes = '{{Session::get('successmsg')}}';
		var exist = '{{Session::has('successmsg')}}';

		if(exist){
			alert(mes);
		}
		
		$(document).ready(function() {
			
			$('.quantity').on('input',function(){
					
					if ($(this).val().length > 0) {
						$(this,".color").parent().parent().css({"background-color":"red","color":"white"});
						
					}else{
						$(this,".color").parent().parent().css({"background-color":"white","color":"grey"});
						
					}
				});

		});

	</script>

@endsection

