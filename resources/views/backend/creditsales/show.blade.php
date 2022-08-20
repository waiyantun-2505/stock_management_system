@extends('backendtemplate')

@section('content')

	<div class="container">
		<ul class="list-group shadow">
			<li class="list-group-item">
				<div class="row">
					<div class="col-md-12 col-lg-12 col-sm-12 text-center">
						<h1><u><span class="text-primary">({{$creditsales->customer->name}})</span> Sale Detail Info</u></h1>
					</div>
					<div class="col-md-12 col-lg-12 col-sm-12 text-center">
						<h4><u>
							@if($creditsales->credit_method == "1week")
								One Week Credit Payment
								@elseif($creditsales->credit_method == "2week")
								Two Week Credit Payment
								@else
								One Month Credit Payment

							@endif
						</u></h4>
					</div>
					<div class="col-md-12 col-lg-12 col-sm-12">
						<a href="{{route('sale_branch',$creditsales->branch_id)}}" class="btn btn-outline-warning">Back</a>
					</div>
				</div>
				<div class="row my-3 text-center">
					<div class="col-md-3 col-sm-3 col-lg-3">
						<div class="card">
							<div class="card-body">
							    <h5 class="card-title">Voucher No</h5><hr>
								<p class="card-text">{{$creditsales->voucher_no}}</p>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-3 col-lg-3">
						<div class="card">
							<div class="card-body">
							    <h5 class="card-title">Branch</h5><hr>
								<p class="card-text">{{$creditsales->branch->name}}</p>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-3 col-lg-3">
						<div class="card">
							<div class="card-body">
							    <h5 class="card-title">Sale Date</h5><hr>
								<p class="card-text">{{$creditsales->saledate}}</p>
							</div>
						</div>
					</div>
					<div class="col-md-3 col-sm-3 col-lg-3">
						<div class="card">
							<div class="card-body">
							    <h5 class="card-title">Balance</h5><hr>
								<p class="card-text">{{$creditsales->balance}}</p>
							</div>
						</div>
					</div>
				</div>
				<div class="row my-3 text-center">
					@if($creditsales->discount != null)
						<div class="col-md-4 col-lg-4 col-sm-4">
							<div class="card">
								<div class="card-body">
								    <h5 class="card-title">Discount Percent</h5><hr>
									<p class="card-text">{{$creditsales->discount}} %</p>
								</div>
							</div>
						</div>
					@endif

					@if($creditsales->bonus != null)
						<div class="col-md-4 col-lg-4 col-sm-4">
							<div class="card">
								<div class="card-body">
								    <h5 class="card-title">Bonus Amount</h5><hr>
									<p class="card-text">{{$creditsales->bonus}} </p>
								</div>
							</div>
						</div>
					@endif

					<div class="col-md-4 col-lg-4 col-sm-4">
						<div class="card">
							<div class="card-body">
							    <h5 class="card-title">Total Amount</h5><hr>
								<p class="card-text">{{$creditsales->total_amount}} </p>
							</div>
						</div>
					</div>

				</div>
			</li>
			<li class="list-group-item">
				<div class="row text-center">
					<div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
						<table class="table table-dark table-hover table-bordered">
							<thead>
								<tr>
									<td colspan="4">Sale Items</td>
								</tr>
								<tr>
									<th>
										No
									</th>
									<th>
										Product Name
									</th>
									<th>
										Quantity
									</th>
									<th>
										Amount
									</th>
								</tr>
							</thead>
							<tbody>
								@php $i=1; @endphp
								@foreach($credit_saledetail as $detail)
									<tr>
										<td>{{$i++}}</td>
										<td>{{$detail->product->name}}</td>
										<td>{{$detail->quantity}}</td>
										<td>{{$detail->amount}}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</li>

			@if(count($promotion) > 0)
				<li class="list-group-item">
					<div class="row text-center">
						<div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
							<table class="table table-dark table-hover table-bordered">
								<thead>
									<tr>
										<td colspan="3">Promotion Items</td>
									</tr>
									<tr>
										<th>
											No
										</th>
										<th>
											Product Name
										</th>
										<th>
											Quantity
										</th>
									</tr>
								</thead>
								<tbody>
									@php $i=1; @endphp
									@foreach($promotion as $promo)
										<tr>
											<td>{{$i++}}</td>
											<td>{{$promo->product->name}}</td>
											<td>{{$promo->quantity}}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</li>
			@endif

			@if(count($credit_sale_return) > 0)
				<li class="list-group-item">
					<div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
						<table class="table table-dark table-hover table-bordered text-center">
							<thead>
								<tr>
									<th colspan="4" style="color: white; background-color: red;">
										<span>Return Items</span>
									</th>
								</tr>
								<tr>
									<th>No</th>
									<th>Product Name</th>
									<th>Return Quantity</th>
									<th>Return Date</th>
								</tr>
							</thead>
							<tbody>
								@php $i=1; @endphp
								@foreach($credit_sale_return as $return)
									<tr>
										<td>{{$i++}}</td>
										<td>{{$return->product->name}}</td>
										<td>{{$return->sale_return}}</td>
										<td>{{$return->return_date}}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</li>
			@endif

		</ul>
	</div>

@endsection

