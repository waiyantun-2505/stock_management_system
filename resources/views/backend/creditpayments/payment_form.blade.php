@extends('backendtemplate')

@section('content')
	
	<div class="container">
		<!-- List group-->
              <ul class="list-group shadow mt-2">
              <!-- list group item-->
                  <li class="list-group-item">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 text-center">
				<h1><u>Credit Payment Form ( <span class="text-danger">{{$name}}</span> )</u></h1>
			</div>
			<div class="col-md-12 col-lg-12 col-sm-12">
				<a href="{{route('payment',$branch_id)}}" class="btn btn-outline-warning">Back</a>
			</div>
		</div>
		<div class="row my-3">
			 <div class="col-md-4 col-lg-4 col-sm-4 text-center">
			 	<div class="card shadow">
				  <div class="card-body">
				    <h5 class="card-title">Sale Voucher No</h5><hr>
				    <p class="card-text">{{$creditsale->voucher_no}}</p>
				  </div>
				</div>
			 </div>
			 <div class="col-md-4 col-lg-4 col-sm-4 text-center">
			 	<div class="card shadow">
				  <div class="card-body">
				    <h5 class="card-title">Total Balance</h5><hr>
				    <p class="card-text">{{$creditsale->balance}}</p>
				  </div>
				</div>
			 </div>
			 <div class="col-md-4 col-lg-4 col-sm-4 text-center">
			 	<div class="card shadow">
				  <div class="card-body">
				    <h5 class="card-title">Paid Amount</h5><hr>
				    <p class="card-text">
				    	{{$paid_amount}}
				    </p>
				  </div>
				</div>
			</div>
		</div>
		
		@if(count($creditpayment) > 0)
			<div class="col-lg-12 col-md-12 col-sm-12 text-center my-3">
				<h5><u>Payment Record (ငွေပေးချေ ခဲ့သော မှတ်တမ်း)</u></h5>
			</div>
			<div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
				<table class="table table-bordered table-hover table-dark">
					<thead class="text-center">
						<tr>
							<th>No</th>
							<th>Payment Voucher no</th>
							<th>Date</th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody class="text-center">
						@php
							$i=1;
						@endphp
						@foreach($creditpayment as $payment)
							<tr>
								<td>
									{{$i++}}
								</td>
								<td>
									{{$payment->voucher_no}}
								</td>
								<td>
									{{$payment->date}}
								</td>
								<td>
									{{$payment->amount}}
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			
		@endif
		<form action="{{route('payment_store',$creditsale->id)}}" method="Post">
			@csrf

			<div class="row">
				
				<div class="col-md-8 col-lg-8 col-sm-8">
					<label>Payment Amount</label>
					<input type="number" id="amount" name="amount" class="form-control @error('amount') @enderror" placeholder="Enter Amount" max="{{$max_amount}}">
					@error('amount')
						<div class="alert alert-danger">{{ $message }}</div>
					@enderror
				</div>
				<div class="col-md-4 col-lg-4 col-sm-4 my-auto">
					<label class="d-block"></label>
					<input type="submit" value="Save" class="btn btn-success float-right">
				</div>
				
			</div>
		</form>
	</li>
</ul>
	</div>

@endsection

@section('script')
	
	<script type="text/javascript">
			
		$(document).ready(function() {
			var mes = '{{Session::get('successmsg')}}';
			var exist = '{{Session::has('successmsg')}}';

			if(exist){
				alert(mes);
			}
		});

	</script>

@endsection()