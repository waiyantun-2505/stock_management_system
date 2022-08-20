@extends('backendtemplate')

@section('content')
	
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 text-center">
				<h1><u>Create New Product</u></h1>
			</div>
		</div>
		<div class="row my-2">
			<div class="col-md-12 col-sm-12 col-lg-12">
				<a href="{{route('products.index')}}" class="btn btn-outline-warning">Back</a>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<form action="{{route('products.store')}}" method="post" class="form-group">
					@csrf

					<label for="name">Name</label>
					<input type="text" name="name" id="name" class="form-control text-capitalize @error('name')  @enderror">
					@error('name')
    				<div class="alert alert-danger">{{ $message }}</div> 	
					@enderror

					
					<div class="row my-3">
						<div class="col-lg-4 col-md-4 col-sm-4">
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

						<div class="col-lg-4 col-md-4 col-sm-4">
							<label for="order_price">Order Price ($) </label>
							<input type="number" name="order_price" id="order_price" class="form-control @error ('order_price') @enderror" placeholder="eg. 10.23 $" step="0.01">
							@error('order_price')
								<div class="alert alert-danger">{{ $order_price }}</div>
							@enderror
						</div>

						<div class="col-lg-4 col-md-4 col-sm-4">
							<label for="sale_price">Sale Price (MMK)</label>
							<input type="number" name="sale_price" id="sale_price" class="form-control @error ('sale_price') @enderror" placeholder="eg. 13000 MMK">
						</div>
						@error('sale_price')
								<div class="alert alert-danger">{{ $sale_price }}</div>
						@enderror

					</div>




					

					<input type="submit" value="Save" class="btn btn-success mt-4 float-right">


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

		
		var mes = '{{Session::get('successmsg')}}';
		var exist = '{{Session::has('successmsg')}}';

		if(exist){
			alert(mes);
		}



	</script>

@endsection