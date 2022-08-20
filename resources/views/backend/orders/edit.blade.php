@extends('backendtemplate')

@section('content')
	<h1 class="text-center font-weight-bold">Edit Order in Detail</h1>
	<form method="post" action="{{route('orders.update',$order->id)}}">
		@csrf
		@method('PUT')

		<div class="container">
			<div class="row">
				<div class="col-md-12 col-lg-12">
						

						<label for="name">Supplier Name</label>
						<input type="text" name="name" id="name" value="{{$order->suppliername}}" class="form-control @error('name')  @enderror">
						@error('name')
		    				<div class="alert alert-danger">{{ $message }}</div> 	
						@enderror

						<label class="font-weight-bold d-block my-2">Order Date</label>
						<div class="col-md-3 col-lg-3">
							<input type="date" name="date" value="{{$order->orderdate}}" class="mb-3 form-control @error('date') @enderror">
						</div>
						@error('date')
							<div class="alert alert-danger">{{ $message }}</div>
						@enderror

				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 col-lg-12 table-responsive">
							@php $i=1;$j=1;$k=1;$l=1;$z=1;$y=1;$x=1; @endphp
							@foreach($branches as $rows)
								<h1 class="text-center font-weight-bold">{{$rows->branch->name}}</h1>
								
								
								<table class="table table-hover table-dark">
								<thead>
									<tr class="text-center">
										<td>No</td>
										<td>Product Name</td>
										<td>Quantity</td>
										<td>Action</td>
									</tr>
								</thead>
								<tbody>
								
								@foreach($orderdetails as $orderdetail)
									@if($rows->branch_id == $orderdetail->branch_id)
										<tr class="text-center checkrow">
											<td scope="row">{{$i++}}</td>
											<td>

												<input type="hidden" name="product_id{{$z++}}" value="{{$orderdetail->product_id}}">

												{{$orderdetail->product->name}}
											</td>
											<td>

												<input type="number" name="quantity{{$l++}}" value="{{$orderdetail->quantity}}" class="form-control " min="0">

											</td>
											<td>

												<input type="hidden" name="branch{{$x++}}" value="{{$rows->branch_id}}">
												
												
												  <input class="form-check-input check" type="checkbox" name="delete{{$y++}}" id="{{$j++}}" value="Delete">
												  <label class="form-check-label" for="{{$k++}}">Delete</label>
												
											</td>
										</tr>
									@endif
								@endforeach
								</tbody>
								</table>
								<hr>
							@endforeach

							
						
				</div>
			</div>

			<!-- button for showing new products -->
			<input type="button" name="moreproducts" class="btn btn-outline-primary" value="Add more Products">

			<div class="col-lg-12 col-md-12 table-responsive mt-4" id="product_table" style="display: none;">
					<table id="dataTable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>No</th>
								<th>Product Name</th>
								<th>Related Subcategory</th>
								
								<th>
									<select id="add_branch_id" name="add_branch_id" class="select1 form-control" onmousedown="if(this.options.length>5){this.size=5;}"  onchange='this.size=0;' onblur="this.size=0;"s>
									<option value="" disabled="disabled" selected="selected">--- Choose Branch ---</option>

									@foreach($all_branch as $branchrow)
										<option value="{{$branchrow->id}}">{{$branchrow->name}}</option>
									@endforeach
								</select>
								
								</th>

								<th>
									<select id="add_branch_id2" name="add_branch_id2" class="select2 form-control" onmousedown="if(this.options.length>5){this.size=5;}"  onchange='this.size=0;' onblur="this.size=0;">
									<option value="" disabled="disabled" selected="selected">--- Choose Branch ---</option>

									@foreach($all_branch as $second_row)
										<option class="{{$second_row->id}}" value="{{$second_row->id}}">{{$second_row->name}}</option>
									@endforeach
								</select>
								
								</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1; $j=1; $z=1;$y=1; ?>
							@foreach($products as $rows)
							<tr>
								<td>
									{{$i++}}
								</td>

								<td>
									{{$rows->name}}
								</td>

								<td>
									{{$rows->subcategory->name}}
								</td>
								
								<td>
									<input type="hidden" name="add_product_id{{$j++}}" value="{{$rows->id}}">
									<input class="quantity1 form-control" type="number" name="first_quantity{{$z++}}" min="0">
									
								</td>

								<td>
									<input class="quantity2 form-control" type="number" name="second_quantity{{$y++}}" min="0">
								</td>

							</tr>

							@endforeach
							
						</tbody>
					</table>
				</div>

			<input type="submit" class="btn btn-primary ml-5" value="Save">
		</div>
	</form>
@endsection

@section('script')
	<script type="text/javascript">
			
		$(document).ready(function() {
			
			$('input[name=moreproducts]').on('click', function(event) {
				
				$('#product_table').toggle();

			});

			//for branches select option

			$('#add_branch_id').change(function(){
				var id = $(this).find(":selected").val();

				if (id) {
					
					$('.'+id).attr({disabled : "disabled"}).siblings().not(':first').removeAttr('disabled');
					// console.log('#'+id);
				}

				var second_id = $('#add_branch_id2').find(":selected").val();
				if (id == second_id) {
					$('#add_branch_id2').prop("selectedIndex",0);
				}
			})

			$('.quantity1, .quantity2').on('input',function(){
				
				if ($(this).val().length > 0) {
					$(this,".color").parent().css({"background-color":"red","color":"white"});
					// $(':input[type="submit"]').prop('disabled', false);
				}else{
					$(this,".color").parent() .css({"background-color":"white","color":"grey"});
					// $(':input[type="submit"]').prop('disabled', true);
				}
			})

			// $('input[type=submit]').on('click',function(){

			// 	if ($('.quantity1').val().length > 0) {
			// 		$('.select1').prop('required',true);
			// 	}else{
			// 		$('.select1').prop('required',false);
			// 	}

			// 	if ($('.quantity2').val().length > 0) {
			// 		$('.select2').prop('required',true);
			// 	}else{
			// 		$('.select2').prop('required',false);
			// 	}

			// })

			$('.quantity1').on('input',function(){
				if ($(this).val().length>0) {
					$('.select1').prop('required',true);
				}else{
					$('.select1').prop('required',false);
				}
			});

			$('.quantity2').on('input',function(){
				if ($(this).val().length > 0) {
					$('.select2').prop('required',true);
				}else{
					$('.select2').prop('required',false);
				}
			});
			

		});

	</script>
	

@endsection