@extends('backendtemplate')

@section('content')
	
	<div class="container">
		<div class="row">
			
			<div class="col-md-12 col-lg-12 col-sm-12 text-center">
				<h3><u>{{$branch->name}} Credit Payment (ပေးချေရန်ကျန်သောဆိုင်များ) </u></h3>
			</div>

			<div class="col-md-12 col-lg-12 col-sm-12">
				<a href="{{route('sale_branch',$branch->id)}}" class="btn btn-outline-warning">Back</a>
				<a href="{{route('creditpayments.show',$branch->id)}}" class="btn btn-primary float-right">Payment Detail</a>
			</div>			
			
			<div class="col-md-12 col-lg-12 col-sm-12 table-responsive mt-3">
				
				<table class="table display table-bordered table-hover" style="border: 4px solid #191970">
					<thead class="text-center bg-dark text-white">
						<tr style="color: white;background-color: #191970;">
							<th colspan="9">One Month Credit Sale</th>
						</tr>
						<tr>
							<th>
								No
							</th>
							<th>
								Voucher No
							</th>
							<th>
								Branch
							</th>
							<th>
								Customer Name
							</th>
							<th>
								Sale Date
							</th>
							<th>
								Balance
							</th>
							<th>
								Pay Amount
							</th>
							<th>
								Remain
							</th>
							<th>
								Action
							</th>
						</tr>
					</thead>
					<tbody class="text-center">
						@if(count($payment_month) > 0)
							@php
								$i=1;
							@endphp
						@foreach($payment_month as $month)
								
								@php 
								$month_date = \Carbon\Carbon::parse($month->saledate)->addMonths(1)->todatestring();
									
								@endphp

								
								
								@if(\Carbon\Carbon::now('Asia/Yangon') > $month_date)

									<tr style="background-color: #e6005c;color: black;">
								@else
									<tr>
									
								@endif
								
								
									
										<td>
											{{$i++}}
										</td>
										<td>
											{{ $month->b_short }}-{{$month->voucher_no}}
										</td>
										<td>
											{{$month->branch->name}}
										</td>
										<td>
											{{$month->customer->name}}
										</td>
										<td>
											{{$month->saledate}}
										</td>
										<td>
											{{$month->balance}}
										</td>
										<td>
											@if($month->payamount == Null)
												0
												@else
												{{$month->payamount}}
											@endif
										</td>
										<td>
											@php
												$remain = $month->balance - $month->payamount;

											@endphp
											{{$remain}}
										</td>
										<td>
											<!-- <a href="{{route('payment_delete',$month->id)}}" class="btn btn-warning">Delete</a> -->
											<a href="{{route('payment_detail',$month->id)}}" class="btn btn-warning">Detail</a>
											<a href="{{route('payment_form',$month->id)}}" class="btn btn-info">Pay</a>
										</td>
									</tr>
								
						@endforeach
						@else
							<tr>
								<td colspan="8">There is No record yet.</td>
							</tr>
						@endif
					</tbody>
				</table>

			</div>

			<!-- two week -->
			<div class="col-md-12 col-lg-12 col-sm-12 table-responsive mt-3">
				
				<table class="table display table-bordered table-hover" style="border: 4px solid #2E8B57">
					<thead class="text-center bg-dark text-white">
						<tr style="color: white;background-color: #2E8B57;">
							<th colspan="9">Two Weeks Credit Sale</th>
						</tr>
						<tr>
							<th>
								No
							</th>
							<th>
								Voucher No
							</th>
							<th>
								Branch
							</th>
							<th>
								Customer Name
							</th>
							<th>
								Sale Date
							</th>
							<th>
								Balance
							</th>
							<th>
								Pay Amount
							</th>
							<th>
								Remaining
							</th>
							<th>
								Action
							</th>
						</tr>
					</thead>
					<tbody class="text-center">
						@if(count($payment_two) > 0)
							@php
							$i=1;
						@endphp
						@foreach($payment_two as $two)
							
									@php 
								$two_date = \Carbon\Carbon::parse($two->saledate)->addWeeks(2)->todatestring();
									
								@endphp

								
								
								@if(\Carbon\Carbon::now('Asia/Yangon') > $two_date)

									<tr style="background-color: #e6005c;color: black;">
								@else
									<tr>
									
								@endif
										<td>
											{{$i++}}
										</td>
										<td>
											{{$two->voucher_no}}
										</td>
										<td>
											{{$two->branch->name}}
										</td>
										<td>
											{{$two->customer->name}}
										</td>
										<td>
											{{$two->saledate}}
										</td>
										<td>
											{{$two->balance}}
										</td>
										<td>
											@if($two->payamount == Null)
												0
												@else
												{{$two->payamount}}
											@endif
										</td>
										<td>
											@php
												$remain = $two->balance - $two->payamount;

											@endphp
											{{$remain}}
										</td>
										<td>
											<a href="{{route('payment_form',$two->id)}}" class="btn btn-info">Pay</a>
										</td>
									</tr>
								
						@endforeach
							@else
							<tr>
								<td colspan="9">There is No record yet.</td>
							</tr>
						@endif
					</tbody>
				</table>

			</div>

			<!-- one week -->
			<div class="col-md-12 col-lg-12 col-sm-12 table-responsive mt-3">
				
				<table class="table display table-bordered table-hover" style="border: 4px solid #F4A460">
					<thead class="text-center bg-dark text-white">
						<tr style="color: white;background-color: #F4A460;">
							<th colspan="9">One Week Credit Sale</th>
						</tr>
						<tr>
							<th>
								No
							</th>
							<th>
								Voucher No
							</th>
							<th>
								Branch
							</th>
							<th>
								Customer Name
							</th>
							<th>
								Sale Date
							</th>
							<th>
								Balance
							</th>
							<th>
								Pay Amount
							</th>
							<th>
								Remaining
							</th>
							<th>
								Action
							</th>
						</tr>
					</thead>
					<tbody class="text-center">
						@if(count($payment_one) > 0)
							@php
							$i=1;
						@endphp
						@foreach($payment_one as $one)
								@php 
								$one_date = \Carbon\Carbon::parse($one->saledate)->addWeeks(1)->todatestring();
									
								@endphp

								
								
								@if(\Carbon\Carbon::now('Asia/Yangon') > $one_date)

									<tr style="background-color: #e6005c;color: black;">
								@else
									<tr>
									
								@endif
										<td>
											{{$i++}}
										</td>
										<td>
											{{$one->voucher_no}}
										</td>
										<td>
											{{$one->branch->name}}
										</td>
										<td>
											{{$one->customer->name}}
										</td>
										<td>
											{{$one->saledate}}
										</td>
										<td>
											{{$one->balance}}
										</td>
										<td>
											@if($one->payamount == Null)
												0
												@else
												{{$one->payamount}}
											@endif
										</td>
										<td>
											@php
												$remain = $one->balance - $one->payamount;

											@endphp
											{{$remain}}
										</td>
										<td>
											<a href="{{route('payment_form',$one->id)}}" class="btn btn-info">Pay</a>
										</td>
									</tr>
								
						@endforeach
						@else
							<tr>
								<td colspan="8">There is No record yet.</td>
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
		
		$(document).ready(function() {
			$('table.display').dataTable();

			
		});

		var mes = '{{Session::get('successmsg')}}';
		var exist = '{{Session::has('successmsg')}}';

		if(exist){
			alert(mes);
		}

	</script>
	
@endsection