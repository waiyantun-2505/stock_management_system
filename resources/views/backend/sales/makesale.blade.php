@extends('backendtemplate')

@section('content')
	
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 text-center">
				<h1 class="font-weight-bold">{{$branch->name}} Sale Form
					@if(empty($promotion_status))

						@else
						<span class="text-success">( Promotion )</span>
					@endif
				</h1>
			</div>
			<div class="col-md-12 col-lg-12 col-sm-12">
				<a href="{{route('sale_branch',$branch->id)}}" class="btn btn-outline-warning">Back</a>
			</div>
			
			<div class="col-lg-12 table-responsive">
			<form method="post" action="{{route('preparesale')}}" class="form-group">
			@csrf
				<input type="hidden" name="branch_id" value="{{$branch->id}}">
				<div class="row mb-5">
					<div class="col-md-3 col-lg-3 col-sm-3">
						<label class="font-weight-bold">Choose Customer</label>
						<select name="customer_name" id="customer_name" class="form-control @error ('customer_name') @enderror">
							<option value="">--- Choose Customer---</option>
							@foreach($customers as $customer)
							<option value="{{$customer->id}}">{{$customer->name}}</option>
							@endforeach
						</select>
						@error('customer_name')
							<div class="alert alert-danger">{{ $message }}</div>
						@enderror
					</div>


					<div class="col-md-3 col-md-3 col-sm-3 form-check">
						<label class="font-weight-bold">Sale Mehtod</label>
						
						<select name="sale_method" id="sale_method" class="form-control @error ('sale_method') @enderror">
							
							<option value="cash">Cash Down Payment</option>
							<option value="credit">1 month Credit Payment</option>
							<option value="1week">1 Week Credit Payment</option>
							<option value="2week">2 Week Credit Payment</option>
							
						</select>
						@error('sale_method')
							<div class="alert alert-danger">{{ $message }}</div>
						@enderror
						
					</div>

					<div class="col-md-3 col-lg-3 col-sm-3">
						<label class="font-weight-bold d-block">Bonus Amount</label>
							
						<input type="number" name="bonus" class="form-control" min="0" placeholder="Enter Bonus">
					</div>

					<div class="col-md-3 col-lg-3 col-sm-3">
						<label class="font-weight-bold d-block">Discount Amount ( % )</label>
							
						<input type="number" name="discount" class="form-control" min="0" max="100" placeholder="Enter Percentage">
							
					</div>

					

				</div>

				<div id="customer_info" class="row border-danger">
					<!-- ajax response data -->

					

				</div>

				<div class="row mb-5">
					<!-- customer's delivery Gate info -->

					<div id="address" class="col-md-4 col-lg-4 col-sm-4">
						
					</div>
					<div id="delivery_gate" class="col-md-4 col-lg-4 col-sm-4">
						
					</div>

					<div id="delivery_phone" class="col-md-4 col-lg-4 col-sm-4">
						
					</div>


				</div>

				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th>Product Name</th>
							<th>Subcategory</th>
							<th>Current Quantity</th>
							<th>Sale Amount</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=1;$j=1;$y=1; ?>
						@foreach($stock as $rows)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$rows->product->name}}</td>
								<td>
									@foreach($product as $row)
										@if($rows->product_id == $row->id)
											{{$row->subcategory->name}}
										@endif
									@endforeach
								</td>
								<td>{{$rows->quantity}}</td>
								<td>
									<input type="hidden" name="product_id{{$j++}}" value="{{$rows->product_id}}">
									<input class="form-control quantity" type="number" name="quantity{{$y++}}" min="0" max="{{$rows->quantity}}">
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>

				@if(!empty($promotion_status))
					
					<input type="button" name="moreProduct" class="btn btn-outline-primary" value="Promotion Items">

					<div id="moreTable" class="col-md-12 col-lg-12 col-sm-12 table-responsive my-3" style="display: none;">
						<table class="table table-hover table-bordered text-center">
							<thead>
								<tr>
									<td colspan="5" style="color: white;background-color: green;"> 
										Promotion Items
									</td>
								</tr>
								<tr>
									<th>No</th>
									<th>Product Name</th>
									<th>Subcategory</th>
									<th>Current Quantity</th>
									<th>Sale Amount</th>
								</tr>
							</thead>
							<tbody>
								<?php $i=1;$j=1;$y=1; ?>
								@foreach($stock as $rows)
									<tr>
										<td>{{$i++}}</td>
										<td>{{$rows->product->name}}</td>
										<td>
											@foreach($product as $row)
												@if($rows->product_id == $row->id)
													{{$row->subcategory->name}}
												@endif
											@endforeach
										</td>
										<td>{{$rows->quantity}}</td>
										<td>
											<input type="hidden" name="promo_product_id{{$j++}}" value="{{$rows->product_id}}">
											<input class="form-control quantity" type="number" name="promo_quantity{{$y++}}" min="0" max="{{$rows->quantity}}">
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@endif

				<input type="submit" value="Make Sale" class="btn btn-success float-right mt-4">
		</form>	
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

		$(document).ready(function(){

			$('input[name=moreProduct]').on('click',function(event) {
				// $('#moreTable').toggle(200);
				$('#moreTable').toggle(150);
			});

			$('table').dataTable();


			$('#customer_name').select2();

			$('.quantity').on('input',function(){
					
					if ($(this).val().length > 0) {
						$(this,".color").parent().parent().css({"background-color":"red","color":"white"});
						
					}else{
						$(this,".color").parent().parent().css({"background-color":"white","color":"grey"});
						
					}
				});

			// customer Info Ajax

			$('#customer_name').change(function(){

				var id = $(this).find(":selected").val();

				var html = "";
				var deli_gate = "";
				var deli_phone = "";
				var marketer = "";
				var address = "";

				$.post('/search_customer',{id:id},function(res){
					// console.log(res);
					if (res) {
						// $.each(res,function(i,v){
						var id = res.id;
						// console.log(id);
						var city_name = res.city.name;
						var way_name = res.way;
						var phone = res.phone;
						// var address = res.address;
						// console.log(address);

						

						if (res.delivery_gate != null) {
							$('#delivery_gate').css('display','block');
							var delivery_gate = res.delivery_gate;

							deli_gate = `
											<div class="card">
											  <div class="card-body">
											    <h5 class="card-title">Delivery Gate</h5><hr>
											    <p class="card-text">${delivery_gate}</p>
											  </div>
											</div>

										`;
							html=deli_gate.replace(':id',res.id);
							$('#delivery_gate').html(html);

						}else{
							$('#delivery_gate').css('display','none');
						}

						if (res.delivery_phone != null ) {
							$('#delivery_phone').css('display','block');
							var delivery_phone = res.delivery_phone;
							deli_phone = `
											<div class="card">
											  <div class="card-body">
											    <h5 class="card-title">Delivery Phone</h5><hr>
											    <p class="card-text">${delivery_phone}</p>
											  </div>
											</div>
										`;
							html=deli_phone.replace(':id',res.id);
							$('#delivery_phone').html(deli_phone);
						}else{
							$('#delivery_phone').css('display','none');
						}

						


						html =`	
								<div class="col-md-4 col-lg-4 col-sm-4 mb-4">

									<div class="card">
									  <div class="card-body">
									    <h5 class="card-title">City Name</h5><hr>
									    <p class="card-text">${city_name}</p>
									  </div>
									</div>

								</div>
								

								<div class="col-md-4 col-lg-4 col-sm-4">

									<div class="card">
									  <div class="card-body">
									    <h5 class="card-title">Phone</h5><hr>
									    <p class="card-text">${phone}</p>
									  </div>
									</div>

								</div>

								
								`

						html=html.replace(':id',res.id);

					
					$('#customer_info').html(html);

					
					
					
					if (res.marketer_id != null) {
							var marketer_name =  res.marketer.name;


							marketer = `
										<div class="col-md-4 col-lg-4 col-sm-4">

											<div class="card">
											  <div class="card-body">
											    <h5 class="card-title">Marketer Name</h5><hr>
											    <p class="card-text">${marketer_name}</p>
											  </div>
											</div>

										</div>
										`;
							html=marketer.replace(':id',res.id);

							$('#customer_info').append(html);
						}

					if (res.address != null) {
							var address =  res.address;


							address = `
										

											<div class="card">
											  <div class="card-body">
											    <h5 class="card-title">Address</h5><hr>
											    <p class="card-text">${address}</p>
											  </div>
											</div>

										
										`;
							html=address.replace(':id',res.id);

							$('#address').html(html);
						}

				}
				});  //end of post

			}); //end of change function

			
		}); // end of ready fucntion
	</script>
@endsection