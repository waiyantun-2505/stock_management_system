@extends('backendtemplate')

@section('content')
	
	<div class="container">
		<div class="col-md-12 col-lg-12 col-sm-12 text-center">
			<h1><u>Transfer Form</u></h1>
		</div>
		<div class="col-md-12 col-lg-12 col-sm-12">
			<a href="{{route('transfers.index')}}" class="btn btn-outline-warning">Back</a>
		</div>		
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<form action="{{route('transfers.store')}}" method="post" class="form-group">
					@csrf


					<div class="row">
						

						<!-- From Branch -->
						<div class="col-lg-6 col-md-6">
							<label for="branchname1">From Branch</label>
							<select id="branchname1" name="branchname1" class="select form-control @error ('branchname1') @enderror" onmousedown="if(this.options.length>3){this.size=3;}"  onchange='this.size=0;' onblur="this.size=0;" searchable="Search here..">
								<option value="" disabled="disabled" selected="selected">--- Choose Branch ---</option>

								@foreach($branches as $rows)
									<option value="{{$rows->id}}">{{$rows->name}}</option>
								@endforeach
							</select>
							@error('branchname1')
								<div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>

						<!-- To Branch -->
						<div class="col-lg-6 col-md-6" id="second">
							<label for="branchname2">To Branch</label>
							<select id="branchname2" name="branchname2" class="select form-control @error ('branchname2') @enderror" onmousedown="if(this.options.length>3){this.size=3;}"  onchange='this.size=0;' onblur="this.size=0;" searchable="Search here..">
								<option value="" disabled="disabled" selected="selected">--- Choose Branch ---</option>

								@foreach($branches as $row)
									<option class="{{$row->id}}" value="{{$row->id}}">{{$row->name}}</option>
								@endforeach
							</select>
							@error('branchname2')
								<div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
	
					</div> <!-- end of row -->

					
					<div class="table-responsive-md mt-4" style="display: none;" id="table" >
						<table id="data_t" class="table  table-bordered">
							<thead>
								<tr>
									<th>No</th>
									<th>Product Name</th>
									<th>Current Stocks</th>
									<th>Transfer Amount</th>
								</tr>
							</thead>
							<tbody id="products" >

							</tbody>
						</table>
					</div>


					<input type="submit" value="Save" class="btn btn-success mt-4 float-right">


				</form>
			</div>
		</div>
	</div>

@endsection

@section('script')
	<script type="text/javascript">


		$('#second').css("display","none");
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
			}
		});

		$(document).ready(function($) {
			
			// input check -> not to overcome current quantity and below 0

			$('.check').on('click',function(){
				var input = $('.value').val();
				if(input == 0) {
				input.setCustomValidity('The number must not be zero.');
				}else{
					input.setCustomValidity('');
				}
			});

			


			$('#branchname1').change(function(event) {
				
				var id = $(this).find(":selected").val();
				if (id) {
					$('#second').css("display","block");
					$('.'+id).attr({disabled : "disabled"}).siblings().not(':first').removeAttr('disabled');
					// console.log('#'+id);
				}

				var second_id = $('#branchname2').find(":selected").val();
				if (id == second_id) {
					$('#branchname2').prop("selectedIndex",0);
				}
				

				$.post('/transfer_search',{id:id},function(res){
					if(res)	{

						$('#table').css("display","block");
						var j = 1;
						var z = 1;
						var y = 1;
						var html = "";

						$.each(res,function(i,v){
							var id = v.id;

							var product_id = v.product_id;
							var product_name = v.product.name;

							// var subcategory_name = v.subcategory.name;

							var current_stock = v.quantity;

							html +=`
								<tr>
									<td>${j++}</td>
									<td><input type="text" name="product_name" value="${product_name}" readonly style="border:0;outline:none;"></td>
									
									<td>
										${current_stock}
									</td>
									<td>
										<input type="hidden" name="product_id${z++}" value="${product_id}">
										<input type="number" class="color_quantity form-control" name="quantity${y++}" min="0" max="${current_stock}">
									</td>
								</tr>
								`
								html=html.replace(':id',v.id);
						})
						$('#products').html(html);

					}
				})

			});

			
			
		});
	</script>
@endsection