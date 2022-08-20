@extends('backendtemplate')

@section('content')
	
	<div class="container">
		<div class="row">
			
			
					<div class="col-md-12 col-lg-12 col-sm-12 text-center">
						<h1><u>Credit Payment</u></h1>
					</div>
					

					<div class="col-md-12 col-lg-12 col-lg-12 table-responsive my-4">
						<table id="dataTable" class="table-bordered table table-hover">
							<thead class="text-center">
								<th>
									No
								</th>
								<th>
									Payment Voucher No.
								</th>
								<th>
									Customer Name
								</th>
								<th>
									Date
								</th>
								<th>
									Amount
								</th>
								<th>
									Action
								</th>
							</thead>
							<tbody class="text-center">
								@php $i=1; @endphp
								@if(count($credit_payments) > 0 )
									@foreach($credit_payments as $payment)
										<tr>
											<td>
												{{$i++}}
											</td>
											<td>
												{{$payment->voucher_no}}
											</td>
											<td>
												{{$payment->creditsale->customer->name}}
											</td>
											
											<td>
												{{$payment->date}}
											</td>
											<td>
												{{$payment->amount}}
											</td>
											<td>
												<a href="{{route('creditpayments.edit',$payment->id)}}" class="btn btn-warning">Edit</a>

												<form method="post" action="{{route('creditpayments.destroy',$payment->id)}}" onclick="return confirm('Are you sure want to delete?')" class="d-inline-block">
													@csrf
													@method('DELETE')
													<button type="submit" class="btn btn-danger">Delete</button>
												</form>

												
											</td>
										</tr>
									@endforeach
									@else
										<tr>
											<td colspan="6">
												There is no <u>Payment</u> records yet.
											</td>
										</tr>
								@endif
							</tbody>
						</table>
					</div>

				

		</div>
	</div>

@endsection


@section('script')
	
	<script type="text/javascript">
		
		var mes = '{{Session::get('successmsg')}}';
		var exist = '{{Session::has('successmsg')}}';

		if(exist){
			alert(mes);
		}

	</script>

@endsection