@extends('backendtemplate')


@section('content')
<h1 class="text-center">Register Customer</h1>
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">
			<a href="{{route('customers.index')}}" class="btn btn-danger float-left mb-3">Back</a>
		</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12">
			<form class="form-group" method="post" action="{{route('customers.store')}}">
			@csrf

				<label for="name">Name</label>
				<input type="text" name="name" id="name" class="form-control text-capitalize @error('name')  @enderror">
				@error('name')
    				<div class="alert alert-danger">{{ $message }}</div> 	
				@enderror

				<label for="phone">Phone</label>
				<div class="phone-list">
				
					<div class="input-group phone-input col-md-5 col-lg-5 col-sm-5">
						
						
						<input type="text" name="phone[]" class="form-control @error('phone')  @enderror" placeholder="Enter Phone Number" / required="">

						<button type="button" class="btn btn-success btn-sm btn-add-phone ml-2"><span class="glyphicon glyphicon-plus"></span> + Add Phone</button>

					</div>
					
					
				</div>
				



				<label class="d-block">Choose City</label>
				<select id="city_id" name="city_id" class="form-control @error ('city_id') @enderror">
					<option value="">Choose City</option>
					@foreach ($cities as $row)
						<option value="{{$row->id}}">{{$row->name}}</option>
					@endforeach
				</select>
				@error('city_id')
    				<div class="alert alert-danger">{{ $message }}</div> 	
				@enderror


				<label for="address">Address</label>
				<textarea id="address" name="address" class="form-control @error ('address') @enderror"></textarea>
				@error('address')
					<div class="alert alert-danger">{{$message}}</div>
				@enderror

				<!-- Add Additional info -->
				<input type="button" id="more" name="moreproducts" class="btn btn-info btn-sm my-2" value="Additional Info +">
				

				<div id="more_info" class="row" style="display: none;">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<label for="wayname">Way Name</label>
						<input type="text" name="wayname" id="wayname" class="form-control text-capitalize">

						<label>Marketer Name</label>
						<select id="marketer_id" name="marketer_id" class="form-control">
							<option value="">Choose Marketer</option>
							@foreach ($marketers as $row)
								<option value="{{$row->id}}">{{$row->name}}</option>
							@endforeach
						</select>

						<label for="delivery_gate">Delivery Gate</label>
						<input type="text" name="delivery_gate" id="delivery_gate" class="form-control  text-capitalize">

						<label for="delivery_phone">Delivery Phone Number</label>
						<div class="delivery-phone-list">
						
							<div class="input-group delivery-phone-input col-md-5 col-lg-5 col-sm-5">
								
								
								<input type="text" name="delivery_phone[]" class="form-control @error('phone')  @enderror" placeholder="Enter Delivery Phone Number" />

								<button type="button" class="btn btn-success btn-sm btn-add-phone_delivery ml-2"><span class="glyphicon glyphicon-plus"></span> + Add Phone</button>
							</div>
							
							
						</div>
						

					</div>
				</div>

				<input type="submit" name="" value="Save" class="btn btn-success mt-4 float-right">

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
			
			$('#city_id').select2();

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