@extends('backendtemplate')

@section('content')
	
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 text-center">
				<h1 class="font-weight-bold">Order Records</h1>
			</div>
			<div class="col-md-12 col-lg-12 col-sm-12 my-3">
				<a href="{{route('orders.create')}}" class="btn btn-primary">Create New +</a>
			</div>
			<div class="col-md-12 col-lg-12 table-responsive">
				<table id="dataTable" class="table table-bordered text-center">
					<thead>
						<tr style="color: white;background-color: green;">
							<td colspan="4">Order Table</td>
						</tr>
						<tr>
							<th>No</th>
							<th>Supplier Name</th>
							<th>Order Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="tbody">
						<?php $i=1;$j=1;$k=1; ?>
						@foreach($orders as $rows)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$rows->suppliername}}</td>
								<td>{{$rows->orderdate}}</td>
								<td>
									<button type="button" class="btn btn-info" data-id="{{$rows->id}}" class="showModal" value="Detail" data-toggle="modal" data-target="#mymodal">Detail</button>

									<a href="{{route('orders.edit',$rows->id)}}" class="btn btn-warning">Edit</a>

									<form method="post" action="{{route('orders.destroy',$rows->id)}}" onclick="return confirm('Are you sure want to delete?')" class="d-inline-block">
										@csrf
										@method('DELETE')
										<button type="submit" class="btn btn-danger">Cancel</button>
									</form>

									<a href="{{route('order_return',$rows->id)}}" class="btn btn-primary">Order Return</a>


								</td>
							</tr>
							
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<hr>

	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-lg-12 text-center">
				<h1><u>Cancel Records</u></h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
				<table class="table table-hover table-bordered text-center">
					<thead>
						<tr style="color: white;background-color: red;">
							<td colspan="4">Order Table <i class="fas fa-ban"> Cancel Records</i></td>
						</tr>
						<tr>
							<th>No</th>
							<th>Supplier Name</th>
							<th>Order Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@if(count($order_cancel) > 0 )
							@php
								$i = 1;
							@endphp

							@foreach($order_cancel as $cancel)
								<tr>
									<td>{{$i}}</td>
									<td>{{$cancel->suppliername}}</td>
									<td>{{$cancel->orderdate}}</td>
									<td>
										<button type="button" class="btn btn-info" data-id="{{$cancel->id}}" class="showModal" value="Detail" data-toggle="modal" data-target="#mymodal">Detail</button>
									</td>
								</tr>
							@endforeach

							@else

						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>

	
<div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Order Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
          <table class="table">
          		<thead>
          			<tr>
          				<th>No</th>
          				<th>Branch Name</th>
          				<th>Product Name</th>
          				<th>Quantity</th>
          				<th>Order Return</th>
          			</tr>
          		</thead>
          		<tbody id="orderdetail" class="text-center">
          			
          		</tbody>
          </table>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
	<script type="text/javascript">

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
			}
		});

		$(document).ready(function() {
			
		
		$('#mymodal').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var id = button.data('id');
		  
		 // console.log(id);

		  $.post('/orderDetail',{id:id},function(res){
					if(res)	{

						var html = "";
						var j = 1;

						$.each(res,function(i,v){
							var id = v.id;
							// console.log(id);
							var product_name = v.product.name;
							var branch_name = v.branch.name;
							var quantity = v.quantity;
							

							if (v.order_return == null) {
								var order_return = "-";
							}else{
								var order_return = v.order_return;
							};
							
							

							html +=`
								<tr>
									<td>
										${j++}
									</td>
									<td>
										${branch_name}
									</td>
									<td>
										${product_name}
									<td>
										${quantity}
									</td>
									
									<td>
										${order_return}
									</td>
									
									
								</tr>
								`
								html=html.replace(':id',v.id);
						})
						$('#orderdetail').html(html);

					}
				})

		  
		  
			})
		});

		var mes = '{{Session::get('successmsg')}}';
		var exist = '{{Session::has('successmsg')}}';

		if(exist){
			alert(mes);
		}
		
	</script>
@endsection