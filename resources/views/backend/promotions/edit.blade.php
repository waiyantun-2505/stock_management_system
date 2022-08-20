@extends('backendtemplate')

@section('content')
	
	<div class="container">
		<ul class="list-group shadow">
			<li class="list-group-item">
				<div class="row">
					
					<div class="col-md-12 col-lg-12 col-sm-12 text-center">
						<h1>Promotion Form</h1>
					</div>
					<div class="col-md-12 col-lg-12 col-sm-12">
						<a href="{{route('promotions.index')}}" class="btn btn-outline-warning"> Back</a> 
					</div>
				
				</div>

				<form action="{{route('promotions.update',$promotion->id)}}" method="post">
					@csrf
					@method('PUT')
					<div class="row">
					
						<div class="col-md-4 col-lg-4 col-sm-4">
							<label>Promotion Name</label>
							<input type="text" name="name" class="form-control @error('name') @enderror" value="{{$promotion->name}}">
							@error('name')
			    				<div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
						<div class="col-md-4 col-lg-4 col-sm-4">
							<label>Start Date</label>
							<input type="date" name="start_date" class="form-control @error('start_date') @enderror" value="{{$promotion->from}}">
							@error('start_date')
			    				<div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
						<div class="col-md-4 col-lg-4 col-sm-4">
							<label>end Date</label>
							<input type="date" name="end_date" class="form-control @error('end_date') @enderror" value="{{$promotion->to}}">
							@error('end_date')
			    				<div class="alert alert-danger">{{ $message }}</div>
							@enderror
						</div>
					
					</div>

					<div class="col">
						<input type="submit" value="Update" class="float-right btn btn-success mt-3">
					</div>

				</form>
			</li>
		</ul>
	</div>

@endsection


@section('script')



@endsection