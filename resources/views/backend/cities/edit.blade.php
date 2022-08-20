@extends('backendtemplate')


@section('content')
<h1 class="text-center"><u>Edit <span class="font-weight-bold">{{$name}}</span> City Info</u></h1>
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">
			<a href="{{route('cities.index')}}" class="btn btn-outline-info float-left mb-3">Back</a>
		</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12">
			<form class="form-group" method="post" action="{{route('cities.update',$city->id)}}">
			@csrf
			@method('PUT')

				<label for="name">Name</label>
				<input type="text" name="name" id="name" class="form-control @error('name')  @enderror" value="{{$city->name}}">
				@error('name')
    				<div class="alert alert-danger">{{ $message }}</div> 	
				@enderror

				<label for="region">Choose Region</label>
				<select id="region" name="region" class="form-control text-capitalize @error('region')  @enderror" >
					<option>Choose Region</option>

					@foreach($regions as $region)
						<option value="{{$region->id}}">{{$region->name}}</option>
					@endforeach
				</select>
				@error('region')
    				<div class="alert alert-danger">{{ $message }}</div> 	
				@enderror

				<input type="submit" name="" value="Update" class="btn btn-primary mt-4">

			</form>
		</div>
			
		</div>
	</div>
@endsection

@section('script')
	


@endsection