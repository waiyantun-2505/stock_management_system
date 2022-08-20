@extends('backendtemplate')

@section('content')

	<div class="container">
		<ul class="list-group shadow">
			<li class="list-group-item">
				
				<div class="col-md-12 col-lg-12 col-sm-12 text-center">
					<h1><u> Waysale Voucher: <span class="text-primary">{{ $waysale_detail->b_short }}-{{ $waysale_detail->voucher_no }}</span> </u></h1>
				</div>
				<div class="col-md-12 col-lg-12 col-sm-12 text-center">
						<h4><u>
							@if($waysale_detail->credit_method == "1week")
								One Week Credit Payment
								@elseif($waysale_detail->credit_method == "2week")
								Two Week Credit Payment
								@else
								One Month Credit Payment

							@endif
						</u></h4>
					</div>

				<div class="col-md-12 col-lg-12 col-sm-12">
					<a href=" {{route('way_sale_detail',$waysale_detail->wayout_id)}} " class="btn btn-outline-warning"> Back </a>
				</div>

			</li>
			
			<li class="list-group-item">
				<div class="row">
					<div class="col-md-4 col-lg-4 col-sm-4">
						<div class="card">
						  <div class="card-body">
						    <h5 class="card-title"><b>Customer Name</b></h5><hr>
						    <p class="card-text"> {{ $waysale_detail->customer->name }} </p>
						  </div>
						</div>
					</div>
					<div class="col-md-4 col-lg-4 col-sm-4">
						<div class="card">
						  <div class="card-body">
						    <h5 class="card-title"><b>Cities</b></h5><hr>
						    <p class="card-text"> {{ $waysale_detail->wayout->way_cities }} </p>
						  </div>
						</div>
					</div>
					<div class="col-md-4 col-lg-4 col-sm-4">
						<div class="card">
						  <div class="card-body">
						    <h5 class="card-title"><b>Way Sale Date</b></h5><hr>
						    <p class="card-text"> {{ $waysale_detail->waysale_date }} </p>
						  </div>
						</div>
					</div>
				</div>

				<div class="row my-2">
					<div class="col-md-4 col-lg-4 col-sm-4">
						<div class="card">
						  <div class="card-body">
						    <h5 class="card-title"><b>Discount</b></h5><hr>
						    <p class="card-text"> {{ $waysale_detail->discount }} </p>
						  </div>
						</div>
					</div>
					<div class="col-md-4 col-lg-4 col-sm-4">
						<div class="card">
						  <div class="card-body">
						    <h5 class="card-title"><b>Bonus</b></h5><hr>
						    <p class="card-text"> @if($waysale_detail->bonus != Null)  {{ $waysale_detail->bonus }}  @else - @endif </p>
						  </div>
						</div>
					</div>
					<div class="col-md-4 col-lg-4 col-sm-4">
						<div class="card">
						  <div class="card-body">
						    <h5 class="card-title"><b>Balance</b></h5><hr>
						    <p class="card-text"> {{ $waysale_detail->balance }} </p>
						  </div>
						</div>
					</div>
				</div>

			</li>
		</ul>

		<ul class="list-group shadow my-4">
			<li class="list-group-item">
				<div class="col my-2">
					<i class="far fa-calendar-check"></i> <span class="h5">Sale Records</span>
				</div>
				<div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
					<table id="dataTable" class="table table-bordered tablr-hover text-center">
						<thead>
							<tr>
								<th>No</th>
								<th>Product Name</th>
								<th>Quantity</th>
								<th>Total Amount</th>
							</tr>
						</thead>
						<tbody>
							@php $i=1; @endphp
							@foreach($waysale_detail->waycreditsaledetails as $detail)
								<tr>
									<td>{{$i++}}</td>
									<td> {{$detail->product->name}} </td>
									<td> {{ $detail->quantity }} </td>
									<td> {{ $detail->amount }} </td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</li>
		</ul>

		@if(count($promotion) > 0)

		<ul class="list-group shadow my-4">
			<li class="list-group-item">
				<div class="col my-2">
					<i class="far fa-calendar-check"></i> <span class="h5">Promotion Items</span>
				</div>
				<div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
					<table id="dataTable" class="table table-bordered tablr-hover text-center">
						<thead>
							<tr>
								<th>No</th>
								<th>Product Name</th>
								<th>Quantity</th>
							</tr>
						</thead>
						<tbody>
							@php $i=1; @endphp
							@foreach($promotion as $item)
								<tr>
									<td> {{$i++}} </td>
									<td> {{$item->product->name}} </td>
									<td> {{ $item->quantity }} </td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</li>
		</ul>		

		@endif

	</div>

@endsection


@section('script')



@endsection