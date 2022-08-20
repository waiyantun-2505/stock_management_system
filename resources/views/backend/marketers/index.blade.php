@extends('backendtemplate')

@section('content')

	<div class="container">
		<ul class="list-group shadow">
			<li class="list-group-item">
				<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 text-center">
				<h1>Marketers List</h1>
			</div>
			<div class="col-md-12 col-lg-12 col-md-12 my-3">
				<a href="{{route('marketers.create')}}" class="btn btn-primary">Create New +</a>

				<!-- <button class="btn btn-info float-right">Search Sales Records</button> -->

				<button class="showModal btn btn-info float-right" value="Detail" data-toggle="modal" data-target="#search_total">Search Sales Records</button>
				
			</div>

			
				
			

			<div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
				<table id="dataTable" class="table table-bordered table-hover">
					<thead class="text-center">
						<tr class="bg-primary text-white">
							<th>No</th>
							<th>Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody class="text-center">

						@if(count($marketers) < 1)
							<tr>
								<td colspan="3" class="text-center"><h3>There is no record yet.</h3></td>
							</tr>
						@else
							@php $i=1;  @endphp
							@foreach($marketers as $marketer)

								<tr>
									<td>{{$i++}}</td>
									<td>
										{{$marketer->name}}
										@php
											$count = $marketer->customers->count();
										@endphp
										<a href="{{ route('marketers.show', $marketer->id ) }}"><span class="badge badge-pill badge-info">{{$count}}</span></a>
									</td>
									<td>
										<button data-id="{{$marketer->id}}" data-url="{{route('marketers.update',$marketer->id) }}" data-name="{{$marketer->name}}" class="showModal btn btn-primary" value="Detail" data-toggle="modal" data-target="#mymodal">Edit</button>

									
									</td>
								</tr>

							@endforeach
						@endif
						

					</tbody>
				</table>
			</div>
		</div>
			</li>
		</ul>
	</div>



<div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">

        <h3 class="modal-title font-weight-bold">Edit Marketer</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
          <form method="post" class="form-group">
          	@csrf
          	@method('PUT')
          	<div class="container">
          		<div class="row">
          			<div class="col-lg-12 col-md-12">
          				<label class="font-weight-bold">Marketer Name</label>
          				<input type="text" name="name" class="form-control" id="name">
          			</div>
          		</div>
          	</div>
          
        
      </div>
      <div class="modal-footer">
      	<input type="submit" value="Save Changes" class="btn btn-primary">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
      </form>
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

		$(document).ready(function() {
			$('#mymodal').on('show.bs.modal', function (event) {
			  var button = $(event.relatedTarget) // Button that triggered the modal
			  var name = button.data('name')
			  var url = button.data('url')

			   
			  var modal = $(this)
			  
			  modal.find('.modal-body #name').val(name);
			  modal.find('.modal-body form').attr("action",url);
			})
		});			
	</script>
	
@endsection