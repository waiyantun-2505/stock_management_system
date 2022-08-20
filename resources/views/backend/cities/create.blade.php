@extends('backendtemplate')


@section('content')
<h1 class="text-center"><u>Register City</u></h1>
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">
			<a href="{{route('cities.index')}}" class="btn btn-outline-info float-left mb-3">Back</a>
		</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12">
			<form class="form-group" method="post" action="{{route('cities.store')}}">
			@csrf

				<label for="name">Name</label>
				<input type="text" name="name" id="name" class="form-control text-capitalize @error('name')  @enderror">
				@error('name')
    				<div class="alert alert-danger">{{ $message }}</div> 	
				@enderror

				<label for="region_id">Choose Region</label>
				<select id="region_id" name="region_id" class="form-control text-capitalize @error('region_id')  @enderror" >
					<option>Choose Region</option>

					@foreach($regions as $region)
						<option value="{{$region->id}}">{{$region->name}}</option>
					@endforeach
				</select>
				@error('region')
    				<div class="alert alert-danger">{{ $message }}</div> 	
				@enderror

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
			$("#region_id").select2();
		});

	</script>
		

@endsection