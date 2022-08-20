@extends('backendtemplate')

@section('content')
	
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<form action="{{route('wayouts.store')}}" method="post" class="form-group">
					@csrf


					<div class="row">
						<div class="col-lg-4 col-md-4">
							<label for="city">Way Citites</label>
							
							<input type="text" id="city" name="city" class="form-control @error('city') @enderror">	
							
							@error('city')
								<div class="alert alert-danger">{{ $message }}</div>
							@enderror	
						</div>

						<!-- From Branch -->
						<div class="col-lg-4 col-md-4">
							<label for="branchname1">Way Out Date</label>
							<input type="date" name="date" class="form-control @error ('date') @enderror">
							@error('date')
								<div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>

						<!-- To Branch -->
						<div class="col-lg-4 col-md-4">
							<label for="branch_id">Way Out Branch</label>
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
	
					</div> <!-- end of row -->

					
					<div class="table-responsive-md mt-4" style="display: none;" id="table" >
						<table id="tab" class="table  table-bordered table-hover display">
							<thead>
								<tr>
									<th>No</th>
									<th>Product Name</th>
									<th>Current Stocks</th>
									<th>Way Stocks</th>
								</tr>
							</thead>
							<tbody id="products" >

							</tbody>
						</table>
					</div>


					<input type="submit" id="submit" value="Save" class="btn btn-success float-right mt-4">


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

			

			$('#branch_id').change(function(event) {
				var id = $(this).find(':selected').val();
				$('#table').css('display','block');


				
				$.post('/wayout_search',{id:id},function(res) {
					if (res) {
						 var html = "";
				 		
						
						var j = 1;
						$.each(res, function(i, v) {
							 var id = v.id;
							 var product_id = v.product_id;
							 var product_name = v.product.name;
							 var current_stock = v.quantity;
							 $('#tab').DataTable();

							 html +=`
								<tr>
									<td>${j}</td>
									<td>
										${product_name}
									</td>
									
									<td>
										${current_stock}
									</td>
									<td>
										<input type="hidden" name="product_id${j}" value="${product_id}">
										<input type="number" class="quantity form-control" name="quantity${j++}" min="0" max="${current_stock}">
									</td>
								</tr>
								`
								html=html.replace(':id',v.id);

						});
						$('#products').html(html);
						
					}
				})

			});
			
			
		});
	</script>
@endsection