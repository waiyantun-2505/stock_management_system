@extends('backendtemplate')

@section('content')
	<h1 class="text-center">Register SubCategory</h1>
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">
			<a href="{{route('subcategories.index')}}" class="btn btn-outline-info float-left mb-3">Back</a>
		</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12">
			<form class="form-group" method="post" action="{{route('subcategories.store')}}">
			@csrf

				<label for="name">Name</label>
				<input type="text" name="name" id="name" class="form-control text-capitalize  @error('name')  @enderror">
				@error('name')
    				<div class="alert alert-danger">{{ $message }}</div> 	
				@enderror

				<label>Category</label>
				<select id="category_id" name="category_id" class="form-control @error ('category_id') @enderror">
					<option value="">--- Choose Category ---</option>
					@foreach($categories as $row)
						<option value="{{$row->id}}">{{$row->name}}</option>
					@endforeach
				</select>
				@error('category_id')
    				<div class="alert alert-danger">{{ $message }}</div> 	
				@enderror

				<input type="submit" name="" value="Save" class="btn btn-success float-right mt-4">

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

	</script>
@endsection