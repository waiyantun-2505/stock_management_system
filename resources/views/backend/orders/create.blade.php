@extends('backendtemplate')


@section('content')
<h1 class="text-center">Make Order</h1>
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">
			<a href="{{route('orders.index')}}" class="btn btn-outline-info float-left mb-3">Back</a>
		</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12">
			<form class="form-group" method="post" action="{{route('orders.store')}}">
			@csrf

				<label for="name">Supplier Name</label>
				<input type="text" name="name" id="name" class="form-control text-capitalize @error('name')  @enderror">
				@error('name')
    				<div class="alert alert-danger">{{ $message }}</div> 	
				@enderror

				


				<div class="col-lg-12 table-responsive my-5">
					<table id="dataTable" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>No</th>
								<th>Product Name</th>
								<th>Related Subcategory</th>
								
								<th>
									<select id="branch_id" name="branch_id" class="select form-control @error ('branch_id') @enderror" onmousedown="if(this.options.length>5){this.size=5;}"  onchange='this.size=0;' onblur="this.size=0;">
									<option value="" disabled="disabled" selected="selected">--- Choose Branch ---</option>

									@foreach($branches as $row)
										<option value="{{$row->id}}">{{$row->name}}</option>
									@endforeach
								</select>
								@error('branch_id')
									<div class="alert alert-danger">{{ $message }}</div>
								@enderror
								</th>

								<th>
									<select id="branch_id2" name="branch_id2" class="select form-control @error ('branch_id2') @enderror" onmousedown="if(this.options.length>5){this.size=5;}"  onchange='this.size=0;' onblur="this.size=0;">
									<option value="" disabled="disabled" selected="selected">--- Choose Branch ---</option>

									@foreach($branches as $second_row)
										<option class="{{$second_row->id}}" value="{{$second_row->id}}">{{$second_row->name}}</option>
									@endforeach
								</select>
								
								</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1; $j=1; $z=1;$y=1; ?>
							@foreach($products as $productrow)
							<tr>
								<td>
									{{$i++}}
								</td>

								<td>
									{{$productrow->name}}
								</td>

								<td>
									{{$productrow->subcategory->name}}
								</td>
								
								<td>
									<input type="hidden" name="add_product_id{{$j++}}" value="{{$productrow->id}}">
									<input class="quantity form-control" type="number" name="first_quantity{{$z++}}" min="0" oninput="check()">
									
								</td>

								<td>
									<input class="quantity form-control" type="number" name="second_quantity{{$y++}}" min="0" oninput="check()">
								</td>

							</tr>

							@endforeach
							
						</tbody>
					</table>
				</div>
					

				<input type="submit" value="Save" class="btn btn-success float-right mt-2">

			</form>
		</div>
			
		</div>
	</div>
@endsection

@section('script')
	
	<script type="text/javascript">
		

		$(document).ready(function(){

			// $(':input[type="submit"]').prop('disabled', true);

			$('#branch_id').change(function(){
				var id = $(this).find(":selected").val();

				if (id) {
					
					$('.'+id).attr({disabled : "disabled"}).siblings().not(':first').removeAttr('disabled');
					// console.log('#'+id);
				}

				var second_id = $('#branch_id2').find(":selected").val();
				if (id == second_id) {
					$('#branch_id2').prop("selectedIndex",0);
				}
			})

			$('.quantity').on('input',function(){
				
				if ($(this).val().length > 0) {
					$(this,".color").parent().parent().css({"background-color":"red","color":"white"});
					// $(':input[type="submit"]').prop('disabled', false);
				}else{
					$(this,".color").parent().parent().css({"background-color":"white","color":"grey"});
					// $(':input[type="submit"]').prop('disabled', true);
				}
			})

			


			
		});

		function check(argument) {
			if(input.value == 0) {
				input.setCustomValidity('The number must not be zero.');
			}else{
				input.setCustomValidity('');
			}
		}




		var mes = '{{Session::get('successmsg')}}';
		var exist = '{{Session::has('successmsg')}}';

		if(exist){
			alert(mes);
		}
	</script>
		

@endsection