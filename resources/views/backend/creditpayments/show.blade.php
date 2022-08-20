@extends('backendtemplate')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 text-center">
				<h1><u>{{ $branch->name }}'s Credit Payment Records</u></h1>
			</div>
			<div class="col-md-12 col-lg-12 col-sm-12">
				<a href="{{ route('payment',$branch->id) }}" class="btn btn-outline-warning">Back</a>
			</div>
			<div class="col-md-12 col-sm-12 col-sm-12 table-responsive my-3">
				<table id="dataTable" class="table table-bordered table-hover text-center">
					<thead>
						<tr class="bg-primary text-white">
							<th>No</th>
							<th>Credit Voucher No</th>
							<th>Sale Voucher No</th>
							<th>Date</th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody>
						@if(count($credit_payments) > 0 )
							@php $i=1; @endphp
							@foreach($credit_payments as $payment)

								<tr>
									<td> {{ $i++ }} </td>
									<td> {{ $payment->voucher_no }} </td>
									<td> {{ $payment->creditsale->voucher_no }} </td>
									<td> {{ $payment->date }} </td>
									<td> {{ $payment->amount }} </td>
								</tr>

							@endforeach

							@else
								<tr>
									<td colspan="5">There is no records yet.</td>
								</tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection

@section('script')



@endsection