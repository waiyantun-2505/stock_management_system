@extends('backendtemplate')

@section('content')

	 <div class="container">
	 	<ul class="list-group shadow">
	 		<li class="list-group-item">
	 			<div class="row">
	 		
	 				<div class="col-md-12 col-lg-12 col-sm-12 text-center">
	 					<h1><u><span class="text-primary">{{ $marketer->name }}'s</span> Shops</u></h1>
	 				</div>

	 				<div class="col-md-12 col-lg-12 col-sm-12">
	 					<a href="{{ route('marketers.index') }}" class="btn btn-warning">Back</a>
	 				</div>
	 			</div>

	 			<div class="row my-4">
	 				<div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
	 					<table id="dataTable" class="table table-bordered table-hover">
	 						<thead class="text-center" >
	 							<tr class="bg-primary text-white">
									<th>No</th>
									<th>Name</th>
									<th>Phone</th>
									<th>Way Name</th>
									<th>Address</th>
									<th>City</th>
									<th>Action</th>
								</tr>
	 						</thead>
	 						<tbody class="text-center">
	 							@if(count($shop_marketers) <1)
							<tr>
								<td colspan="5">There is no record in this table.</td>
							</tr>
						@else
							<?php $i=1; ?>
						<?php foreach ($shop_marketers as $row): ?>
							<tr>
								<td>{{$i++}}</td>
								<td>{{$row->name}}</td>
								@php
									$explodes = explode(',',$row->phone);
									$count = count($explodes);

								@endphp
								<td>
									@foreach($explodes as $explode)
										
										{{$explode}} <br>

									@endforeach

								</td>
								@if($row->way == null)
									<td> - </td>
								@else
									<td>{{$row->way}}</td>
								@endif

								@if($row->marketer_id == null)
									<td> - </td>
								@else
									<td>{{$row->marketer->name}}</td>
								@endif

								<td>{{$row->city->name}}</td>
								<td>
									@php
										$delivery_gate = '';
										$delivery_phone = '';

										if($row->delivery_gate == null){
											$delivery_gate = "There is no Delivery Gate for This Shop.";
										}
										else{
											$delivery_gate = $row->delivery_gate;
										}
										

										if($row->delivery_phone == null){
											$delivery_phone = "There is no Phone Number for This Shop.";
										}
										else{
											$delivery_phone = $row->delivery_phone;
										}
										
									@endphp

									

									<button type="button" class="btn btn-info" data-shop="{{$row->name}}" data-id="{{$row->id}}" data-name="{{$delivery_gate}}" data-phone="{{$delivery_phone}}" class="showModal" value="Detail" data-toggle="modal" data-target="#mymodal"><i class="far fa-circle"></i></button>

									<a href="{{route('customers.edit',$row->id)}}" class="btn btn-primary"><i class="far fa-edit"></i></a>
									
								</td>
							</tr>
						<?php endforeach ?>
						@endif
	 						</tbody>
	 					</table>
	 				</div>
	 			</div>
	 		</li>
	 	</ul>
	 </div>

	 <!-- Modal Box -->

	 <!-- modal box -->
	<div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delivery Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
          <div class="container">
          		<div class="row">
          			<div class="col-lg-12 col-md-12">
          				<label class="font-weight-bold h3 badge badge-info">Delivery Gate</label>
          				<span id="name"></span>
          			</div>
          		</div>
          	</div>

          	<div class="container">
          		<div class="row">
          			<div class="col-lg-12 col-md-12">
          				<label class="font-weight-bold h3 badge badge-info">Delivery Phone</label>
          				<span id="phone"></span>
          				
          			</div>
          		</div>
          	</div>
        
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
		
		$(document).ready(function() {
			$('#mymodal').on('show.bs.modal', function (event) {
			  var button = $(event.relatedTarget); // Button that triggered the modal
			  
			  var phone = button.data('phone');
			  var name = button.data('name');
			  var shop = button.data('shop');
			  

			  


			   
			  var modal = $(this)
			  
			  modal.find('.modal-body #name').text(name);
			  modal.find('.modal-title').text(shop);
			  modal.find('.modal-body #phone').text(phone);
			})
		});

	</script>

@endsection