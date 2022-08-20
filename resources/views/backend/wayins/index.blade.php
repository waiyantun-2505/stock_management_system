@extends('backendtemplate')

@section('content')
	
	<h1 class="text-center">Way In</h1>

	<div class="container-fluid my-2">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">
				<a href="{{route('waysales.index')}}" class="btn btn-outline-info float-right mx-2">Way Sale</a>
				<a href="{{route('wayouts.index')}}" class="btn btn-outline-info float-right">Way Out</a>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>No</th>
							<th>Wayout Branch</th>
							<th>Wayin Branch</th>
							<th>Duration</th>
							<th>Way Sale Records</th>
						</tr>
					</thead>
					<tbody>
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
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Modal Box  -->

	<!-- Modal -->
	<div class="modal fade" id="saleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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