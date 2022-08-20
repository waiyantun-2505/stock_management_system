@extends('backendtemplate')

@section('content')

	<h1 class="text-center text-uppercase"><b>Way</b> Records</h1>

	<div class="container-fluid my-2">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">
				<a href="{{route('wayouts.create')}}" class="btn btn-primary float-left">Way Out Create + </a>
				<a href="{{route('wayadd_pending')}}" class="btn btn-outline-primary float-right mx-2">Pending Stock Add</a>
				<a href="{{route('wayouts.index')}}" class="btn btn-outline-primary float-right mx-2">Way Out</a>
				<a href="{{route('wayins.index')}}" class="btn btn-outline-primary float-right">Way In</a>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row my-3">
			<div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
				<table class="table table-bordered table-hover text-center">
					<thead>
						<tr>
							<th>No</th>
							<th>Way Out Branch</th>
							<th>Way Out Date</th>
							<th>Way Cities</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						
						@if(count($wayouts_ongoing) > 0)
							@php $i=1; @endphp
							@foreach($wayouts_ongoing as $wayout)							
							<tr>
								<td>{{$i++}}</td>
								<td>{{$wayout->branch->name}}</td>
								<td>{{$wayout->wayout_date}}</td>
								<td> {{ $wayout->way_cities }} </td>
								<td>
									
									<a href="{{route('way_sale_detail',$wayout->id)}}" class="btn btn-warning">Detail</a>

									<a href="{{route('way_sale',$wayout->id)}}" class="btn btn-primary">Way Sale</a>

									<button type="button" data-url="{{route('wayadd_form',$wayout->id)}}" class="btn btn-info" data-toggle="modal" data-target="#waystock">
									  Way Stock Add
									</button>

									<a href="{{route('way_in',$wayout->id)}}" class="btn btn-danger" onclick="return confirm('Are you sure you want to way in??');"> Way In</a>

								</td>
							</tr>
							
							@endforeach
						@else
							<tr class="text-center">
								<td colspan="5">There is no <strong>way</strong> in this time</td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>

		<div class="row mt-5">
			<div class="col-md-12 col-lg-12 col-sm-12">
				<h1 class="card-info text-center">Previous Way Records</h1>
			</div>
			<div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
				<table class="table-bordered table table-hover">
					<thead>
						<tr>
							<th>No</th>
							<th>Wayout Branch</th>
							<th>Wayin Branch</th>
							<th>Way Duration</th>
							<th>Way Sale Records</th>
						</tr>
					</thead>

					<tbody>
						@php 
							$j=1; 
							
						@endphp
						@foreach($wayouts_done as $done)
						@php
							$wayout_date = Carbon\Carbon::parse($done->wayout_date);
							$wayin_date = Carbon\Carbon::parse($done->wayins->wayin_date);
							$duration = $wayout_date->diffInDays($wayin_date);
						@endphp
							<tr>
								<td>{{$j++}}</td>
								<td>{{$done->branch->name}}</td>
								<td>{{$done->wayins->branch->name}}</td>
								<td>{{$duration}} Days</td>
								<td>
									@foreach($waysales as $waysale)
										@if($done->id == $waysale->wayout_id)
											
											
											<button type="button" class="badge badge-success" data-id="{{$waysale->id}}" data-toggle="modal" data-target="#saleModal">
											  {{$waysale->waysale_date}}
											</button>
										@else	
											<span>There is no <strong>Sale Record</strong> in this way.</span>
											@break;
										@endif
									@endforeach
								</td>
							</tr>
						@endforeach
					</tbody>

				</table>
			</div>
		</div>
	</div>


	<!-- Modal Box  -->

	<!-- Modal Box for way stock add -->
	<!-- Modal -->
		<div class="modal fade" id="waystock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title text-primary" id="waystock">Choose Branch To Add Stock</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      	<form id="form" method="post">
		      		@csrf
			      <div class="modal-body">
			        <select name="branch_id" class="form-control">
			        	@foreach($branches as $branch)
			        		<option value="{{$branch->id}}">{{$branch->name}}</option>
			        	@endforeach
			        </select>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			        <button type="sumit" class="btn btn-primary">Add</button>
			      </div>
		      	</form>
		    </div>
		  </div>
		</div>

	<!-- Modal -->
	<!-- <div class="modal fade" id="saleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Sale Detail</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body table-responsive">

	        <table class="table table-bordered table-hover">
	        	<thead>
	        		<tr>
	        			<td>No</td>
	        			<td>Product Name</td>
	        			<td>Quantity</td>
	        		</tr>
	        	</thead>
	        	<tbody id="waysale_detail">
	        		
	        	</tbody>
	        </table>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	      </div>

	    </div>
	  </div>
	</div> -->


@endsection


@section('script')
	
	<script type="text/javascript">

		var mes = '{{Session::get('successmsg')}}';
		var exist = '{{Session::has('successmsg')}}';

		if(exist){
			alert(mes);
		}
		
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
			}
		});

		$(document).ready(function() {

			$('#waystock').on('show.bs.modal', function (event){
				var button = $(event.relatedTarget);
				var url = button.data('url');

				$('#form').attr('action',url);
			});

			$('#saleModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget) // Button that triggered the modal
			var id = button.data('id');



			$.post('/waysale_detail', {id:id}, function(res) {
				if (res) {

					var html="";
					var k=1;

					$.each(res, function(i, v) {
						 var product_name = v.product.name;
						 var quantity = v.quantity;
						 
						 html +=`
								<tr>
									<td>
									${k++}
									</td>
									<td>
										${product_name}
									<td>
										${quantity}
									</td>
									
								</tr>
								`
						 html=html.replace(':id',v.id);
					});
					$('#waysale_detail').html(html);
				}
			});
		});
		});

	</script>

@endsection