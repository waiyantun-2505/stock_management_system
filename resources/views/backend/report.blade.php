@extends('backendtemplate')

@section('content')
	
	<div class="container">
		<!-- <form action="{{route('generate_report')}}" method="post"> -->
		<form method="post" action="{{route('generate_report')}}" class="form-group">
		@csrf
			<div class="row">
				
					<div class="col-md-12 col-lg-12 col-sm-12">
						<h1 class="text-center">Monthly Report</h1>
						
					</div>
				
			</div>
			<div class="row">
				<div class="col-md-6 col-lg-6 col-sm-6">
					
					<h3>Choose Month to Produce Report</h3>
					<select name="branch_id" class="select form-control @error ('branch_id') @enderror" onmousedown="if(this.options.length>3){this.size=3;}"  onchange='this.size=0;' onblur="this.size=0;" searchable="Search here..">
					<option value="" disabled="disabled" selected="selected">--- Choose Branch ---</option>

					@foreach($branches as $rows)
						<option value="{{$rows->id}}">{{$rows->name}}</option>
					@endforeach
				</select>
				@error('branch_id')
					<div class="alert alert-danger">{{ $message }}</div>
				@enderror
				
				</div>
				<div class="col-md-6 col-lg-6 col-sm-6">
					
					<h3>Choose Month to Produce Report</h3>
					<input type="month" name="report_date" id="startDate" class="form-control date-picker @error ('report_date') @enderror" />
					@error('report_date')
						<div class="alert alert-danger">{{ $message }}</div>
					@enderror

				</div>
			</div>

			<div class="row">
				
				<div class="col-md-auto col-lg-auto col-sm-auto mt-3">
				
					<input type="submit" class="btn btn-success text-center" value="Generate Report">

				</div>

			</div>

		</form> 
	</div>	


@endsection

@section('script')
	
	

@endsection