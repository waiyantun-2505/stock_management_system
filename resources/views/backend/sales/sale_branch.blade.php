@extends('backendtemplate')

@section('content')
	
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 text-center">
				<h1 id="title"><u> {{$branch->name}} Sale Records</u></h1>
			</div> 

			<div class="col-md-12 col-lg-12">
				<a href="{{route('makesale',$branch->id)}}" class="btn btn-primary">Create New +</a>

				
				<!-- <button class="btn btn-success float-right" id="today_sale">Today Sales</button> -->
				<a href="{{route('sales.index')}}" class="btn btn-secondary"> Change Branch</a>
				<a href="{{route('payment',$branch->id)}}" class="btn btn-warning float-right">Credit Payment</a>
				
			</div>

			<div id="text" class="col-md-12 col-lg-12 table-responsive mt-3">
				<table id="dataTable" class="tabl table table-bordered">
					<thead>
						<tr>
							<td colspan="6" style="background:#426AD2;color: white;" class="text-center"> 
								Cash Sale Table
							</td>
						</tr>
						<tr>
							<th>No</th>
							<th>Voucher No</th>
							<th>Customer Name</th>
							<th>Balance</th>
							<th>Sale Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="tbody">
						<?php $i=1;$j=1;$k=1; ?>
						@foreach($sale as $rows)
							<tr>
								<td>{{$i++}}</td>
								<td>  {{ $rows->b_short }}-{{ $rows->voucher_no }}</td>
								<td>{{$rows->customer->name}}</td>
								<td>{{$rows->balance}}</td>
								<td>{{$rows->saledate}}</td>
								<td>
									
									<a href="{{route('sales.show',$rows->id)}}" class="btn btn-info">Detail</a>
									<a href="{{route('sales.edit',$rows->id)}}" class="btn btn-warning">Edit</a>

									<a href="{{route('sale_return',$rows->id)}}" class="btn btn-primary">Sale Return</a>
									
									<form method="post" action="{{route('sales.destroy',$rows->id)}}" onclick="return confirm('Are you sure want to cancel?')" class="d-inline-block">
										@csrf
										@method('DELETE')
										<button type="submit" class="btn btn-danger">Cancel</button>
									</form>

									

								</td>
							</tr>
							
						@endforeach
					</tbody>
				</table>
				
			</div>

			<hr>

			<div id="text" class="col-md-12 col-lg-12 table-responsive my-5">
				<table class="tabl table table-bordered">
					<thead>
						<tr>
							<td colspan="6" style="background:#E53820;color: white;" class="text-center"> 
								Credit Sale Table
							</td>
						</tr>
						<tr>
							<th>No</th>
							<th>Voucher No</th>
							<th>Customer Name</th>
							<th>Balance</th>
							<th>Sale Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="tbody">
						<?php $i=1;$j=1;$k=1; ?>
						@foreach($credit_sale as $credit)
							<tr>
								<td>{{$i++}}</td>
								<td> {{ $credit->b_short }}-{{ $credit->voucher_no }}</td>
								<td>{{$credit->customer->name}}</td>
								<td>{{$credit->balance}}</td>
								<td>{{$credit->saledate}}</td>
								<td>

									<a href="{{route('creditsales.show',$credit->id)}}" class="btn btn-info">Detail</a>

									<a href="{{route('creditsales.edit',$credit->id)}}" class="btn btn-warning">Edit</a>

									<form method="post" action="{{route('creditsales.destroy',$credit->id)}}" onclick="return confirm('Are you sure want to delete?')" class="d-inline-block">
										@csrf
										@method('DELETE')
										<button type="submit" class="btn btn-danger">Cancel</button>
									</form>

									<a href="{{route('credit_sale_return',$credit->id)}}" class="btn btn-primary">Sale Return</a>

								</td>
							</tr>
							
						@endforeach
					</tbody>
				</table>
				
			</div>
		</div>
	</div>

	<hr>
	<!-- Cancel Record -------------------------------------------------------------------------- -->
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 text-center">
				<h1><u>Cancel Records</u></h1>
			</div>
			<div id="text" class="col-md-12 col-lg-12 table-responsive mt-3">
				<table id="dataTable" class="tabl table table-bordered">
					<thead>
						<tr>
							<td colspan="7" style="background:#426AD2;color: white;" class="text-center"> 
								Cash Sale Table <i class="fas fa-ban"> Cancel Records</i>
							</td>
						</tr>
						<tr>
							<th>No</th>
							<th>Voucher No</th>
							<th>Customer Name</th>
							<th>Balance</th>
							<th>Sale Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="tbody" class="text-center">
						@if(count($sale_cancel) > 0 )
							<?php $i=1;$j=1;$k=1; ?>
							@foreach($sale_cancel as $rows)
								<tr>
									<td>{{$i++}}</td>
									<td>{{$rows->b_short}}-{{$rows->voucher_no}}</td>
									<td>{{$rows->customer->name}}</td>
									<td>{{$rows->balance}}</td>
									<td>{{$rows->saledate}}</td>
									<td>
										
										<a href="{{route('sales.show',$rows->id)}}" class="btn btn-info">Detail</a>
										
										

									</td>
								</tr>
								
							@endforeach
							@else
							<td colspan="6">
								<span>There is no cancel records.</span>
							</td>
						@endif
					</tbody>
				</table>
				
			</div>



			<div id="text" class="col-md-12 col-lg-12 table-responsive mt-3">
				<table id="dataTable" class="tabl table table-bordered">
					<thead>
						<tr>
							<td colspan="7" style="background:#E53820;color: white;" class="text-center"> 
								Credit Sale Table <i class="fas fa-ban"> Cancel Records</i>
							</td>
						</tr>
						<tr>
							<th>No</th>
							<th>Voucher No</th>
							<th>Customer Name</th>
							<th>Balance</th>
							<th>Sale Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="tbody">
						@if(count($creditsale_cancel) > 0 )
							<?php $i=1;$j=1;$k=1; ?>
							@foreach($creditsale_cancel as $rows)
								<tr>
									<td>{{$i++}}</td>
									<td>{{$rows->b_short}}-{{$rows->voucher_no}}</td>
									<td>{{$rows->customer->name}}</td>
									<td>{{$rows->balance}}</td>
									<td>{{$rows->saledate}}</td>
									<td>
										
										<a href="{{route('creditsales.show',$rows->id)}}" class="btn btn-info">Detail</a>
										
										

									</td>
								</tr>
								
							@endforeach
							@else
							<td colspan="6" class="text-center">
								<span>There is no cancel records.</span>
							</td>
						@endif
					</tbody>
				</table>
				
			</div>

			
			

		</div>
	</div>

	


@endsection

@section('script')
	<script type="text/javascript">

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
			}
		});

		$(document).ready(function() {
			
			$(".tabl").dataTable();

			$('#refresh').on('click', function(event) {
				location.reload(true);
			});
		
		


			$('#today_sale').on('click',function(){

				$('#refresh').show();


				$.post('/today_sale', function(res) {
					
					if (res) {

						var html = "";
						var j=1;
						$.each(res, function(i,v) {
							var id = v.id;
							var branch_name = v.branch.name;
							var customer_name = v.customer.name;
							var saledate = v.saledate;

							//send javascript var with laravel route ********
							var url = '{{ route("sales.edit", ":id") }}';
								url = url.replace(':id',id);

							// console.log(id);	

							html = `
								<tr>
									<td>${j++}</td>
									<td>${branch_name}</td>
									<td>${customer_name}</td>
									<td>${saledate}</td>
									<td>
										<button type="button" class="btn btn-primary" data-id="${id}" class="showModal" value="Detail" data-toggle="modal" data-target="#mymodal">Detail</button>
										<a href="${url}" class="btn btn-warning">Edit</a>
									</td>
								</tr>
							`

						});
						$('#tbody').html(html);

					}

				});

			})
			
			var mes = '{{Session::get('successmsg')}}';
			var exist = '{{Session::has('successmsg')}}';

			if(exist){
				alert(mes);
			}

		});

		
		
	</script>
@endsection