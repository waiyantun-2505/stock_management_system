@extends('backendtemplate')

@section('content')
<a href="https://www.facebook.com/sharer/sharer.php?u=https://intothegloss.com/2020/12/best-gifts-for-a-holiday-at-home/&display=popup"> share this </a>
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 text-center">
				<h1><u>Promotion Table</u></h1>
			</div>

			@if(empty($promotion))
				<div class="col-md-12 col-lg-12 col-sm-12" >
					<a href="{{route('promotions.create')}}" class="btn btn-primary">Create New +</a>
				</div>
				@else
				<div class="col-md-12 col-lg-12 col-sm-12" >
					<span class="text-primary">There is already active promotion.</span>
				</div>
			@endif
			
		</div>
		<div class="row my-4">
			<div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
				<table class="table table-hover table-bordered text-center">
					<thead>
						<tr>
							<td colspan="5" style="color: white;background-color: green;">
								Active Promotion
							</td>
						</tr>
						<tr>
							<th>No</th>
							<th>Promotion Name</th>
							<th>Start Date</th>
							<th>End Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if(empty($promotion))
							<tr>
								<td colspan="5"><span>There is no Promotion Now</span></td>
							</tr>
						@else
						@php $i=1; @endphp
							
								<tr>
									<td>{{$i++}}</td>
									<td>{{$promotion->name}}</td>
									<td>{{$promotion->from}}</td>
									<td>{{$promotion->to}}</td>
									<td>
										<a href="{{route('promotions.edit',$promotion->id)}}" class="btn btn-primary">Edit</a>
									</td>
								</tr>
							
						@endif
					</tbody>
				</table>
			</div>
		</div>

		<div class="row my-4">
			<div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
				<table class="table table-hover table-bordered text-center">
					<thead>
						<tr>
							<td colspan="4" style="color: white;background-color: red;">
								Previous Promotion
							</td>
						</tr>
						<tr>
							<th>No</th>
							<th>Promotion Name</th>
							<th>Start Date</th>
							<th>End Date</th>
						</tr>
					</thead>
					<tbody>
						@if(count($end_promotion) > 0 )
							
							@php $i=1; @endphp
							
								@foreach($end_promotion as $end)
									<tr>
										<td>{{$i++}}</td>
										<td>{{$end->name}}</td>
										<td>{{$end->from}}</td>
										<td>{{$end->to}}</td>
									</tr>
								@endforeach

						@else
							
							<tr>
								<td colspan="4"><span>There is no Previous Promotion Now</span></td>
							</tr>
							
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