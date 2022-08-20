@extends('backendtemplate')

@section('content')
	
	<div class="container-fluid">
		<ul class="list-group shadow">
			<li class="list-group-item">
				<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 text-center">
				<h1><u>Wayouts</u></h1>
			</div>

			<div class="container-fluid my-2">
				<div class="row">
					<div class="col-md-12 col-lg-12 col-sm-12">
						<a href="{{route('wayouts.create')}}" class="btn btn-primary float-left mx-2">Create New +</a>
						<a href="{{route('waysales.index')}}" class="btn btn-outline-primary float-right mx-2">Way Sale</a>
						<a href="{{route('wayins.index')}}" class="btn btn-outline-primary float-right">Way In</a>
					</div>
				</div>
			</div>

			<div class="table-responsive">
				<table class="data table table-bordered table-hover">
					<thead class="bg-primary text-white">
						<tr>
							<th>No</th>
							<th>Wayout Branch</th>
							<th>Way Citites</th>
							<th>Wayout Date</th>
							<th>Wayin_status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@php $i=1; @endphp
						@foreach($wayouts as $wayout)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$wayout->branch->name}}</td>
								<td>{{$wayout->way_cities}}</td>
								<td>{{$wayout->wayout_date}}</td>
								<td>
									@if($wayout->wayin_status == 'Ongoing')
										<span class="badge badge-pill badge-success">{{$wayout->wayin_status}}</span>
										@elseif($wayout->wayin_status == 'Done')
										<span class="badge badge-pill badge-danger">{{$wayout->wayin_status}}</span>
									@endif
								</td>
								<td>
									
									<button type="button" class="btn btn-info" data-id="{{$wayout->id}}" class="showModal" value="Detail" data-toggle="modal" data-target="#mymodal">Detail</button>

									@if($wayout->wayin_status == 'Ongoing')
										<a href="{{route('wayouts.edit',$wayout->id)}}" class="btn btn-primary">Edit</a>

										<form method="post" action="{{route('wayouts.destroy',$wayout->id)}}" onclick="return confirm('Are you sure want to Cancel?')" class="d-inline-block">
										@csrf
										@method('DELETE')
											<button type="submit" class="btn btn-danger">Cancel</button>
										</form>
									@endif

									

								</td>
						@endforeach
					</tbody>
				</table>
			</div>

			<hr>

			<div class="col-md-12 col-lg-12 col-sm-12 table-responsive my-4">
				<table class="data table table-bordered table-hover text-center">
					<thead class="bg-primary text-white">
						<tr><th colspan="6" class="bg-danger text-white">Cancel Records</th></tr>
						<tr>
							<th>No</th>
							<th>Wayout Branch</th>
							<th>Way Citites</th>
							<th>Wayout Date</th>
							<th>Wayin_status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@php $i=1; @endphp
						@foreach($wayout_cancel as $cancel)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$cancel->branch->name}}</td>
								<td>{{$cancel->way_cities}}</td>
								<td>{{$cancel->wayout_date}}</td>
								<td>
									@if($cancel->wayin_status == 'Ongoing')
										<span class="badge badge-pill badge-success">{{$cancel->wayin_status}}</span>
										@elseif($cancel->wayin_status == 'Done')
										<span class="badge badge-pill badge-danger">{{$cancel->wayin_status}}</span>
									@endif
								</td>
								<td>
									
									<button type="button" class="btn btn-info" data-id="{{$cancel->id}}" class="showModal" value="Detail" data-toggle="modal" data-target="#mymodal">Detail</button>

									

								</td>
						@endforeach
					</tbody>
				</table>
			</div>

		</div>
			</li>
		</ul>
	</div>

	<!-- modal box -->

	<div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Wayout Detail</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	       
	          <table class="table">
	          		<thead>
	          			<tr>
	          				<th>No</th>
	          				<th>Product</th>
	          				<th>Quantity</th>
	          				
	          			</tr>
	          		</thead>
	          		<tbody id="wayoutDetail" class="text-center">
	          			
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

			$('table.data').dataTable();
			
		
		$('#mymodal').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var id = button.data('id');

		  // console.log(id);
		  

		  $.post('/wayoutDetail',{id:id},function(res){
					if(res)	{

						var html = "";
						var j = 1;

						$.each(res,function(i,v){
							var id = v.id;

							var product_name = v.product.name;
							var quantity = v.quantity;
							
							
							
							
							

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
						$('#wayoutDetail').html(html);

					}
				})		  
			})
		});
		

	</script>
@endsection