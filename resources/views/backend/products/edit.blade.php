@extends('backendtemplate')

@section('content')
	
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<ul class="list-group">
					<li class="list-group-item">
						<div class="col-md-12 col-lg-12 col-sm-12 text-center">
							<h1><u>{{$product->name}} Edit Form</u></h1>
						</div>
						<form action="{{route('products.update',$product->id)}}" method="post" class="form-group">
						@csrf
						@method('PUT')

						<label for="name">Name</label>
						<input type="text" name="name" id="name" class="form-control @error('name')  @enderror" value="{{$product->name}}">
						@error('name')
	    				<div class="alert alert-danger">{{ $message }}</div> 	
						@enderror

						<label for="subcategoryname">Choose Subcategory</label>
						<select id="subcategoryname" name="subcategoryname" class="form-control @error ('subcategoryname') @enderror">
							<option value="">--- Choose Subcategory ---</option>

							@foreach($subcategories as $row)
								<option value="{{$row->id}}" @if($product->subcategory_id == $row->id) {{'selected'}} @endif>{{$row->name}}</option>
							@endforeach
						</select>

						<label for="order_price">Order Price</label>
						<input type="number" name="order_price" id="order_price" class="form-control @error('order_price')  @enderror" value="{{$product->order_price}}" step="0.01">
						@error('order_price')
	    				<div class="alert alert-danger">{{ $message }}</div> 	
						@enderror

						<label for="sale_price">Sale Price</label>
						<input type="number" name="sale_price" id="sale_price" class="form-control @error('sale_price')  @enderror" value="{{$product->sale_price}}">
						@error('sale_price')
	    				<div class="alert alert-danger">{{ $message }}</div> 	
						@enderror

						

						<input type="submit" value="Update" class="btn btn-primary mt-4">
					</form>
					</li>
				</ul>
			</div>
		</div>
	</div>

@endsection

@section('script')
	
	<script type="text/javascript">

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