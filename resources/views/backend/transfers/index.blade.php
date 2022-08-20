@extends('backendtemplate')

@section('content')
	
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 text-center">
				<h1 class="font-weight-bold">Transfer Records</h1>
			</div>
			<div class="col-md-12 col-lg-12 col-sm-12 my-3">
				<a href="{{route('transfers.create')}}" class="btn btn-primary">Create New +</a>
			</div>
			<div class="col-md-12 col-lg-12 table-responsive">
				<table id="dataTable" class="table table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th>From Branch</th>
							<th>To Branch</th>
							<th>Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="tbody">
						<?php $i=1;$j=1;$k=1; ?>
						@foreach($transfers as $rows)
							<tr>
								<td>{{$i++}}</td>
								<td>
									@foreach($branches as $branch)
										@if($branch->id == $rows->from_branch)
											{{$branch->name}}
										@endif
									@endforeach
								</td>
								<td>
									@foreach($branches as $branch)
										@if($branch->id == $rows->to_branch)
											{{$branch->name}}
										@endif
									@endforeach
								</td>
								<td>{{$rows->transfer_date}}</td>
								<td>
									<button type="button" class="btn btn-info" data-id="{{$rows->id}}" class="showModal" value="Detail" data-toggle="modal" data-target="#mymodal">Detail</button>

									<a href="{{route('transfers.edit',$rows->id)}}" class="btn btn-warning">Edit</a>

									<form method="post" action="{{route('transfers.destroy',$rows->id)}}" onclick="return confirm('Are you sure want to delete?')" class="d-inline-block">
										@csrf
										@method('DELETE')
										<button type="submit" class="btn btn-danger">Delete</button>
									</form>


								</td>
							</tr>
							
						@endforeach
					</tbody>
				</table>

				
				
				{{ $transfers->links() }}
				
			</div>
		</div>
	</div>

	
<div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Transfer Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
          <table class="table">
          		<thead class="text-center">
          			<tr>
          				<th>No</th>
          				<th>Product Name</th>
          				<th>Quantity</th>
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

		  $.post('/transferDetail',{id:id},function(res){
					if(res)	{

						var html = "";
						var j = 1;

						$.each(res,function(i,v){
							var id = v.id;
							// console.log(id);
							var product_name = v.product.name;
							var quantity = v.quantity;
							console.log(product_name);
							html +=`
								<tr>
									<td>
										${j++}
									</td>
									<td>
										${product_name}
									<td>
										${quantity}
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