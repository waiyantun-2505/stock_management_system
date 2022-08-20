@extends('backendtemplate')


@section('content')
	
	<div class="container">
		<ul class="list-group shadow">
			<li class="list-group-item">
				<div class="row">
					<div class="col-md-12 col-lg-12 col-sm-12 text-center">
						<h1><u> Way Sale Records For <span>{{ $wayout->way_cities }} </u></span></h1>
					</div>
					<div class="col-md-12 col-lg-12 col-sm-12">
						<a href=" {{ route('waysales.index') }} " class="btn btn-outline-warning">Back</a>
					</div>
				</div>
			</li>
			<li class="list-group-item">
				<div class="row">
					<div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
						<table class="table table-hover table-bordered">
							<thead>
								<tr class="bg-success text-white text-center">
									<th colspan="9">Cash Sale Table</th>
								</tr>
								<tr>
									<th>No</th>
									<th>Voucher Number</th>
									<th>Customer Name</th>
									<th>Sale Date</th>
									<th>Balance</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>

								@if(count($waySales) > 0)
									@php $i=1; @endphp

									@foreach($waySales as $cash)

										<tr>
											<td>{{ $i++ }}</td>
											<td> {{ $cash->b_short }}-{{ $cash->voucher_no }} </td>
											<td> {{$cash->customer->name}} </td>
											<td> {{ $cash->waysale_date }} </td>
											<td> {{ $cash->balance }} </td>
											<td>
												<a href="{{route('waysales.show',$cash->id)}}" class="btn btn-info">Detail</a>

												<a href="{{route('waysales.edit',$cash->id)}}" class="btn btn-warning">Edit</a>

												<form method="post" action="{{route('waysales.destroy',$cash->id)}}" onclick="return confirm('Are you sure want to Cancel?')" class="d-inline-block">
													@csrf
													@method('DELETE')
													<button type="submit" class="btn btn-danger">Cancel</button>
												</form>

											</td>
										</tr>

									@endforeach

									@else
										<td class="text-center" colspan="9">
											<span>There is no record yet.</span>
										</td>
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</li>

			<li class="list-group-item">
				<div class="row">
					<div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
						<table class="table table-hover table-bordered">
							<thead>
								<tr class="bg-danger text-white text-center">
									<th colspan="9">Credit Sale Table</th>
								</tr>
								<tr>
									<th>No</th>
									<th>Voucher Number</th>
									<th>Customer Name</th>
									<th>Sale Date</th>
									<th>Balance</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>

								@if(count($wayCreditSales) > 0)
									@php $i=1; @endphp

									@foreach($wayCreditSales as $credit)

										<tr>
											<td>{{ $i++ }}</td>
											<td> {{ $credit->b_short }}-{{ $credit->voucher_no }} </td>
											<td> {{$credit->customer->name}} </td>
											<td> {{ $credit->waysale_date }} </td>
											<td> {{ $credit->balance }} </td>
											<td> 
												<a href="{{route('waycreditsales.show',$credit->id)}}" class="btn btn-info">Detail</a>

												<a href="{{route('waycreditsales.edit',$credit->id)}}" class="btn btn-warning">Edit</a>

												<form method="post" action="{{route('waycreditsales.destroy',$credit->id)}}" onclick="return confirm('Are you sure want to delete?')" class="d-inline-block">
													@csrf
													@method('DELETE')
													<button type="submit" class="btn btn-danger">Cancel</button>
												</form>
											</td>
										</tr>

									@endforeach

									@else
										<td class="text-center" colspan="9">
											<span>There is no record yet.</span>
										</td>
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</li>

			<li class="list-group-item">
				<button class="btn btn-primary" id="show">Show Cancel Records</button>
			</li>
		</ul>

		<ul id="cancel_table" class="list-group shadow" style="display: none;">
			<li class="list-group-item">
				<div class="row">
					<div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
						<table class="table table-hover table-bordered">
							<thead>
								<tr class="bg-success text-white text-center">
									<th colspan="9">Cash Sale Table ( Cancel Records )</th>
								</tr>
								<tr>
									<th>No</th>
									<th>Voucher Number</th>
									<th>Customer Name</th>
									<th>Sale Date</th>
									<th>Balance</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>

								@if(count($cancel_waySales) > 0)
									@php $i=1; @endphp

									@foreach($cancel_waySales as $cash)

										<tr>
											<td>{{ $i++ }}</td>
											<td> {{ $cash->b_short }}-{{ $cash->voucher_no }} </td>
											<td> {{$cash->customer->name}} </td>
											<td> {{ $cash->waysale_date }} </td>
											<td> {{ $cash->balance }} </td>
											<td> action </td>
										</tr>

									@endforeach
										@else
										<td class="text-center" colspan="9">
											<span>There is no record yet.</span>
										</td>

								@endif
							</tbody>
						</table>
					</div>
				</div>
			</li>

			<li class="list-group-item">
				<div class="row">
					<div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
						<table class="table table-hover table-bordered">
							<thead>
								<tr class="bg-danger text-white text-center">
									<th colspan="9">Credit Sale Table ( Cancel Records )</th>
								</tr>
								<tr>
									<th>No</th>
									<th>Voucher Number</th>
									<th>Customer Name</th>
									<th>Sale Date</th>
									<th>Balance</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>

								@if(count($cancel_wayCreditSales) > 0)
									@php $i=1; @endphp

									@foreach($cancel_wayCreditSales as $credit)

										<tr>
											<td>{{ $i++ }}</td>
											<td> {{ $credit->b_short }}-{{ $credit->voucher_no }} </td>
											<td> {{$credit->customer->name}} </td>
											<td> {{ $credit->waysale_date }} </td>
											<td> {{ $credit->balance }} </td>
											<td> action </td>
										</tr>

									@endforeach

									@else
										<td class="text-center" colspan="9">
											<span>There is no record yet.</span>
										</td>
								@endif
							</tbody>
						</table>
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
			$('#show').on('click',function(){
				$('#cancel_table').toggle(2000);
			});
		});

	</script>

@endsection