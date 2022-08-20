@extends('backendtemplate')

@section('content')
	
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 text-center">
				<h1>Create New Marketer</h1>
			</div>
			<div class="col-md-12 col-lg-12 col-sm-12 my-3">
				<a href="{{route('marketers.index')}}" class="btn btn-danger">Back</a>

			</div>
			<div class="col-md-12 col-lg-12 col-sm-12">
				<form method="post" action="{{route('marketers.store')}}">
				@csrf
					<label>Name</label>
					<input type="text" name="name" class="form-control text-capitalize" placeholder="Enter Marketer Name">

					<input type="submit" name="" value="Save" class="btn btn-success mt-4 float-right">
				</form>
			</div>
		</div>
	</div>

@endsection

@section('script')

@endsection