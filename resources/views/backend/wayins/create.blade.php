@extends('backendtemplate')

@section('content')
	
	<h1 class="text-center text-primary"><b>Way In</b> Detail Records</h1>

	<form action="{{route('wayins.store')}}" method="post">
		@csrf
		<input type="hidden" name="wayout_id" value="{{$wayout_record->id}}">
	<div class="container">
		<div class="row">
			
			<div class="col-md-12 col-lg-12 col-sm-12">
				<div class="col-md-12">
					<h3><b>Way Out</b> Detail</h3>
				</div>
				<div class="row text-centere">
					<div class="col-md-4 col-lg-4">
						<label><b>Way Out Branch</b></label>
						<span class="d-block">{{$wayout_record->branch->name}}</span>
					</div>
					<div class="col-md-4 col-lg-4">
						 <label><b>Way Out Date</b></label>
						 <span class="d-block">{{$wayout_record->wayout_date}}</span>
					</div>
					<div class="col-md-4 col-lg-4">
						<label><b>Way Cities</b></label>
						<span class="d-block">{{$wayout_record->way_cities}}</span>
					</div>
				</div>
			</div>

			<div class="col-md-12 col-lg-12 col-sm-12 mt-4">
				<div class="col-md-12">
					<h3><b>Way Out</b> Detail</h3>
				</div>
				<div class="row">
					<div class="col-md-6 col-lg-6">
						<label for="branch_id"><b>Way In Branch</b></label>
						<select id="branch_id" name="branch_id" class="select form-control @error ('branch_id') @enderror" onmousedown="if(this.options.length>3){this.size=3;}"  onchange='this.size=0;' onblur="this.size=0;" searchable="Search here..">
							<option value="" disabled="disabled" selected="selected">--- Choose Branch ---</option>

							@foreach($branches as $row)
								<option class="{{$row->id}}" value="{{$row->id}}">{{$row->name}}</option>
							@endforeach
						</select>
						@error('branch_id')
							<div class="alert alert-danger">{{ $message }}</div>
						@enderror
					</div>
					<div class="col-md-6 col-lg-6">
						<label for="branchname1"><b>Way In Date</b></label>
						<input type="date" name="date" class="form-control date @error ('date') @enderror">
						@error('date')
							<div class="alert alert-danger">{{ $message }}</div>
						@enderror
					</div>
				</div>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
				<h1 class="text-center"><b>Way In</b> Stock</h1>
				<table class="table table-bordered table-hover table-dark">
					<thead>
						<tr>
							<th>No</th>
							<th>Product Name</th>
							<th>Quantity</th>
						</tr>
					</thead>
					<tbody>
						@php $i=1; @endphp
						@foreach($wayout_detail as $detail)
							@if($detail != null)
								
								<tr>
								@if($detail->quantity ==  $detail->sale_quantity)
								@else
								@php $remain_stock = $detail->quantity - $detail->sale_quantity; @endphp
								<td>{{$i++}}</td>
								<td>{{$detail->product->name}}</td>
								<td>{{$remain_stock}}</td>
								@endif
							</tr>
							@else
								<tr>
									<span>There is no way in this time.</span>
								</tr>
							@endif
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		
		<button id="sale_record" class="btn btn-outline-primary">View Sale Records</button>
		<input type="submit" class="btn btn-primary ml-5" value="Way In">
		</form>

		<div id="choose_sale" class="row" style="display: none;">
			<div class="col-md-12 col-lg-12 col-sm-12">
				<h1 class="text-center"><b>Way Sales</b> Records</h1>
				<select id="waysale" name="way_sale" class="form-control">
					
					<option value="" disabled="disabled" selected="selected">--- Choose Sale ---</option>

					@foreach($waysale as $row)
						@if($row->waysale_date == null)
							<option>There is no Sale Record in this way</option>
						@else
						<option value="{{$row->id}}">{{$row->waysale_date}}</option>
						@endif
						
					@endforeach

				</select>
			</div>
		</div>

		<div class="row mt-5">
			<div class="col-md-12 col-lg-12 col-sm-12 table-responsive" style="display: none;" id="sale_table">
				<table class="table table-bordered table-hover table-dark">
					<thead>
						<tr>
							<th>No</th>
							<th>Product Name</th>
							<th>Quantity</th>
						</tr>
					</thead>
					<tbody id="tbody">
						
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

			// $("input[type=date]").datepicker({
			//   dateFormat: 'yyyy-mm-dd',
			 
 		// 	});

			// // Code below to avoid the classic date-picker
			// $("input[type=date]").on('click', function() {
			//   return false;
			// });

			$('#sale_record').on('click', function(event) {
				
				$('#choose_sale').toggle(150);

			});

			$('#waysale').change(function(){
				
				var id = $(this).find(":selected").val();	
				
				
				$('#sale_table').css('display','block');
				
				var j =1;
				var html = "";

				$.post('/waysale',{id:id},function(res){
					if (res) {
						
						$.each(res,function(i,v){
						var id = v.id;
						var name = v.product.name;
						var quantity = v.quantity;
						console.log(name);
						console.log(quantity);
						
						html +=`
								<tr>
									<td>${j++}</td>
									<td>${name}</td>
									<td>
										${quantity}
									</td>
								</tr>
								`
					html=html.replace(':id',v.id);

					});
						$('#tbody').html(html);
					}

					

				});
			})

		});

	</script>

@endsection