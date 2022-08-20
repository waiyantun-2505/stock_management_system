@extends('backendtemplate')

@section('content')
	
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-md-12">
				<h1 class="text-center">Branches Table</h1>
			</div>

			<div class="col-md-12 col-lg-12 col-sm-12 my-2">
				<a href="{{route('branches.create')}}" class="btn btn-primary">Create New +</a>
			</div>

			<div class="col-md-12 col-lg-12 col-sm-12 table-responsive my-2">
				<table id="dataTable" class="table table-bordered">
					<thead class="text-center">
						
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Phone</th>
							<th>Address</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody class="text-center">
						@if(count($branches) < 0)

							<tr>
								<td>There is no Branch record yet.</td>
							</tr>

							@else
							@php
								$i=1;
							@endphp
							@foreach($branches as $branch)

								<tr>
									<td>{{$i++}}</td>
									<td>
										{{$branch->name}}
									</td>
									<td>
										{{$branch->phone}}
									</td>
									<td>
										{{$branch->address}}
									</td>
									<td>

										<a href="{{route('branches.edit',$branch->id)}}" class="btn btn-primary">Edit</a>

										

									</td>
								</tr>

							@endforeach
						@endif
					</tbody>
				</table>
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