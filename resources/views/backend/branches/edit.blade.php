@extends('backendtemplate')


@section('content')
<h1 class="text-center">Register New Branch</h1>
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">
			<a href="{{route('branches.index')}}" class="btn btn-outline-info float-left mb-3">Back</a>
		</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12">
			<form class="form-group" method="post" action="{{route('branches.update',$branch->id)}}">
			@csrf
			@method('PUT')


				<label for="name">Name</label>
				<input type="text" name="name" id="name" class="form-control @error('name')  @enderror" value="{{$branch->name}}">
				@error('name')
    				<div class="alert alert-danger">{{ $message }}</div> 	
				@enderror

				<label for="phone">Phone</label>
				<div class="phone-list">
				
					<div class="input-group phone-input col-md-5 col-lg-5 col-sm-5">
						
						
						<input type="number" name="phone[]" class="form-control @error('phone')  @enderror" placeholder="Enter Phone Number" value="{{$phone[0]}}" />

						<button type="button" class="btn btn-success btn-sm btn-add-phone ml-2"><span class="glyphicon glyphicon-plus"></span> + Add Phone</button>
						@error('phone')
		    				<div class="alert alert-danger">{{ $message }}</div> 	
						@enderror
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


				<label for="address">Address</label>
				<textarea id="address" name="address" class="form-control @error ('address') @enderror">{{$branch->address}}</textarea>
				@error('address')
					<div class="alert alert-danger">{{$message}}</div>
				@enderror

				<input type="submit" name="" value="Save" class="btn btn-primary mt-4">

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
			
			$(document.body).on('click', '.btn-remove-phone' ,function(){
				$(this).closest('.phone-input').remove();
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


		});
	</script>
		

@endsection