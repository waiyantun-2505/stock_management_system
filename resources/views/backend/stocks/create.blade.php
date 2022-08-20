@extends('backendtemplate')

@section('content')
	
	<div class="container">
		<div class="row mb-3">
			<div class="col-md-12 col-lg-12 col-sm-12 text-center">
				<h1><u>Add Stock to Branch</u></h1>
			</div>
			<div class="row">
				<div class="col-md-12 col-lg-12 col-sm-12">
					<a href="{{route('stocks.index')}}" class="btn btn-outline-warning">Back</a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<form action="{{route('stocks.store')}}" method="post" class="form-group">
					@csrf


					<div class="row">

						<div class="col-lg-6 col-md-6">
						<label for="branchname">Choose Branch</label>
					<select id="branchname" name="branchname" class="select form-control @error ('branchname') @enderror" onmousedown="if(this.options.length>3){this.size=3;}"  onchange='this.size=0;' onblur="this.size=0;" searchable="Search here..">
						<option value="" disabled="disabled" selected="selected">--- Choose Branch ---</option>

						@foreach($branches as $rows)
							<option value="{{$rows->id}}">{{$rows->name}}</option>
						@endforeach
					</select>
					@error('branchname')
						<div class="alert alert-danger">{{ $message }}</div>
					@enderror
					</div>

						<div class="col-lg-6 col-md-6">
						<label for="subcategoryname">Choose Subcategory</label>
						<select id="subcategoryname" name="subcategoryname" class="select form-control @error ('subcategoryname') @enderror" onmousedown="if(this.options.length>5){this.size=5;}"  onchange='this.size=0;' onblur="this.size=0;">
							<option value="" disabled="disabled" selected="selected">--- Choose Subcategory ---</option>

							@foreach($subcategories as $row)
								<option value="{{$row->id}}">{{$row->name}}</option>
							@endforeach
						</select>
						@error('subcategoryname')
							<div class="alert alert-danger">{{ $message }}</div>
						@enderror
					</div>

					</div> <!-- end of row -->

					
						<div class="table-responsive-md mt-4" style="display: none;" id="table" >
							<table class="table  table-bordered">
								<thead>
									<tr>
										<th>No</th>
										<th>Product Name</th>
										<th>Related Subcategory</th>
										<th>Add Amount</th>
									</tr>
								</thead>
								<tbody id="products">

								</tbody>
							</table>
						</div>


					<input type="submit" value="Save" class="check btn btn-success float-right mt-4">


				</form>
			</div>
		</div>
	</div>

@endsection

@section('script')
	
	<script type="text/javascript">

		
		$(document).ready(function() {
		    $('.select').select2();
		});

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
			}
		});

		$(document).ready(function($) {
			$('#subcategoryname').change(function(){
				
				var id = $(this).find(":selected").val();	
				
				// console.log(id);
				var j =1;
				var z = 1;
				var y = 1;

				var html = "";

				$.post('/search_product',{id:id},function(res){
					if (res) {
						$('#table').css("display","block");
						$.each(res,function(i,v){
						var id = v.id;
						var name = v.name;
						var subcategory_id = v.subcategory.name;
						// var currstock = v.stock.quantity;

						// console.log(id,name,subcategory_id.name);

						html +=`
								<tr>
									<td>${j++}</td>
									<td>${name}</td>
									<td>${subcategory_id}</td>
									<td><input type="hidden" name="product_id${z++}" value="${id}">
										<input type="number" class="value form-control" name="quantity${y++}" min="0">
									</td>
								</tr>
								`
					html=html.replace(':id',v.id);

					});
						$('#products').html(html);
					}else{
						$('#products').text('there is no product.');
					}

					

				});
			})



			// to check input value not to under 0
			$('.check').on('click',function(){
				var input = $('.value').val();
				if(input == 0) {
				input.setCustomValidity('The number must not be zero.');
				}else{
					input.setCustomValidity('');
				}
			});


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