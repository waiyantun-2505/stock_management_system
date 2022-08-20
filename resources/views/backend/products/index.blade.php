@extends('backendtemplate')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12 mb-3">
				<h1 class="text-center">Create New Product</h1>
				<a href="{{route('products.create')}}" class="btn btn-primary">Create New +</a>
			</div>
			<div class="col-lg-12 table-responsive">
				<table id="dataTable" class="table table-striped table-bordered">
					<thead class="text-center">
						<tr>
							<th>No</th>
							<th>Product Code</th>
							<th>Name</th>
							<th>Related Subcategory</th>
							<th>Order Price</th>
							<th>Sale Price</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody class="text-center">
						@if(count($products) < 1)
							<tr>
								<td colspan="7">There is no product yet.</td>
							</tr>
						@else
							<?php $i=1; ?>
							<?php foreach ($products as $row): ?>
								<tr>
									<td>{{$i++}}</td>
									<td>{{$row->code_no}}</td>
									<td>{{$row->name}}</td>
									<td>{{$row->subcategory->name}}</td>
									<td class="text-right">{{$row->order_price}} $</td>
									<td class="text-right">{{$row->sale_price}} MMK</td>
									
									<td>
										
										<a href="{{route('products.edit',$row->id)}}" class="btn btn-primary"><i class="far fa-edit">Edit</i></a>
										
									</td>
								</tr>
							<?php endforeach ?>
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