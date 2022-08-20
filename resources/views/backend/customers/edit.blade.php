@extends('backendtemplate')


@section('content')
<h1 class="text-center">Edit Customer</h1>
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">
			<a href="{{route('customers.index')}}" class="btn btn-outline-info float-left mb-3">Back</a>
		</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12">
			<form class="form-group" method="post" action="{{route('customers.update',$customer->id)}}">
			@csrf
			@method('PUT')

				<label for="name">Name</label>
				<input type="text" name="name" id="name" class="form-control @error('name')  @enderror" value="{{$customer->name}}">
				@error('name')
    				<div class="alert alert-danger">{{ $message }}</div> 	
				@enderror



				<label for="phone">Phone</label>
				<div class="phone-list">
				
					<div class="input-group phone-input col-md-5 col-lg-5 col-sm-5">
						
						
						
						<input type="number" name="phone[]" class="form-control @error('phone')  @enderror" placeholder="Enter Phone Number" / required="" value="{{$phone[0]}}">

						<button type="button" class="btn btn-success btn-sm btn-add-phone ml-2"><span class="glyphicon glyphicon-plus"></span> + Add Phone</button>


					</div>
						
						@if(count($phone) > 0)
							@php 
								$count = count($phone);
							@endphp
							@for ($i=1; $i < $count; $i++) 
				                
				                	
				                		<div class="input-group phone-input my-2 col-md-5 col-lg-5 col-sm-5">
											<input type="text" name="phone[]" class="form-control m-0" value="{{$phone[$i]}}">
											<span class="input-group-btn">
												<button class="btn btn-danger btn-remove-phone" type="button"><i class="far fa-times-circle"></i></button>
											</span>
										</div>
				                	
				                

				            @endfor
							
						@endif
					
				</div>
				



				<label>Choose City</label>
				<select id="city_id" name="city_id" class="form-control @error ('city_id') @enderror">
					<option value="">--- Choose City ---</option>
					@foreach ($cities as $row)
						<option value="{{$row->id}}" @if($customer->city_id == $row->id) {{'selected'}} @endif>{{$row->name}}</option>
					@endforeach
				</select>
				@error('city_id')
    				<div class="alert alert-danger">{{$message}}</div> 	
				@enderror




				<label for="address">Address</label>
				<textarea id="address" name="address" class="form-control @error ('address') @enderror">{{$customer->address}}</textarea>
				@error('address')
					<div class="alert alert-danger">{{$message}}</div>
				@enderror

				<!-- Add Additional info -->
				<input type="button" id="more" name="moreproducts" class="btn btn-info btn-sm my-2" value="Additional Info +">
				

				<div id="more_info" class="row" style="display: none;">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<label for="wayname">Way Name</label>
						<input type="text" name="wayname" id="wayname" class="form-control" value="{{$customer->way}}">

						<label>Marketer Name</label>
						<select id="marketer_id" name="marketer_id" class="form-control">
							<option value="">Choose Marketer</option>
							@foreach ($marketers as $row)
								<option value="{{$row->id}}" @if($customer->marketer_id == $row->id) {{'selected'}} @endif>{{$row->name}}</option>
							@endforeach
						</select>

						<label for="delivery_gate">Delivery Gate</label>
						<input type="text" name="delivery_gate" id="delivery_gate" class="form-control" value="{{$customer->delivery_gate}}">

						<label for="delivery_phone">Delivery Phone Number</label>
						<div class="delivery-phone-list">
						
							<div class="input-group delivery-phone-input col-md-5 col-lg-5 col-sm-5">
								
								@php
									$d_p = [];
									if(isset($delivery_phone[0])){

									$number = $delivery_phone[0];
									$d_p[0] = $number;

									}else{
										$d_p[0] = Null;
									}
								@endphp

								
								

								<input type="number" name="delivery_phone[]" class="form-control" value="{{$d_p[0]}}" placeholder="Enter Delivery Phone Number" />

								<button type="button" class="btn btn-success btn-sm btn-add-phone_delivery ml-2"><span class="glyphicon glyphicon-plus"></span> + Add Phone</button>
							</div>
								
							@if(count($delivery_phone) > 0)
								@php 
									$count = count($delivery_phone);
								@endphp
								@for ($j=1; $j < $count; $j++) 
					                
					                	
			                		<div class="input-group delivery-phone-input my-2 col-md-5 col-lg-5 col-sm-5">
										<input type="text" name="delivery_phone[]" class="form-control m-0" value="{{$delivery_phone[$j]}}">
										<span class="input-group-btn">
											<button class="btn btn-danger btn-remove-delivery-phone" type="button"><i class="far fa-times-circle"></i></button>
										</span>
									</div>
					                	
					                

					            @endfor
								
							@endif
							
						</div>
						

					</div>
				</div>

				<input type="submit" name="" value="Update" class="btn btn-success mt-4 float-right">

			</form>
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

		$(document).ready(function() {
			
			$('#more').on('click', function(event) {
				
				$('#more_info').toggle(600);

			});

		});



		$(document.body).on('click', '.btn-remove-phone' ,function(){
			$(this).closest('.phone-input').remove();
		});

		$(document.body).on('click', '.btn-remove-delivery-phone' ,function(){
			$(this).closest('.delivery-phone-input').remove();
		});


		$('.btn-add-phone').click(function(){

				var index = $('.phone-input').length + 1;
				
				$('.phone-list').append(''+
						'<div class="input-group phone-input my-2 col-md-5 col-lg-5 col-sm-5">'+
							'<input type="text" name="phone[]" class="form-control">'+
							'<span class="input-group-btn">'+
								'<button class="btn btn-danger btn-remove-phone" type="button"><i class="far fa-times-circle"></i></button>'+
							'</span>'+
						'</div>'
				);

			});

		$('.btn-add-phone_delivery').click(function(){

				var index = $('.delivery-phone-input').length + 1;
				
				$('.delivery-phone-list').append(''+
						'<div class="input-group delivery-phone-input my-2 col-md-5 col-lg-5 col-sm-5">'+
							'<input type="text" name="delivery_phone[]" class="form-control">'+
							'<span class="input-group-btn">'+
								'<button class="btn btn-danger btn-remove-delivery-phone" type="button"><i class="far fa-times-circle"></i></button>'+
							'</span>'+
						'</div>'
				);

			});
	</script>

@endsection