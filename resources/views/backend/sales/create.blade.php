@extends('backendtemplate')

@section('content')
	<div class="container">
		<div class="row">
				<div class="col-md-12 mb-4 text-center">
					<h2>Choose Branch For Make Sale</h2>
				</div>
			@foreach($branches as $rows)
				
				<div class="col-lg-6 col-md-6" align="center">
					<i class="fas fa-store fa-4x"></i>
					<a href="{{route('makesale',$rows->id)}}"><h4>{{$rows->name}}</h4></a>
				</div>
				
			@endforeach
			
		</div>
	</div>
@endsection

@section('script')

@endsection