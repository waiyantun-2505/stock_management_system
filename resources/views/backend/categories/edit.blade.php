@extends('backendtemplate')


@section('content')
<h1 class="text-center">Edit Category</h1>
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">
			<a href="{{route('categories.index')}}" class="btn btn-outline-info float-left mb-3">Back</a>
		</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12">
			<form class="form-group" method="post" action="{{route('categories.update',$category->id)}}">
			@csrf
			@method('PUT')

				<label for="name">Name</label>
				<input type="text" name="name" id="name" class="form-control  @error('name')  @enderror" value="{{$category->name}}">
				@error('name')
    				<div class="alert alert-danger">{{ $message }}</div> 	
				@enderror

				<input type="submit" name="" value="Update" class="btn btn-primary mt-4">

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