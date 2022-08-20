@extends('backendtemplate')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 text-center">
				<h1><u>Regions</u></h1>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12">
				<a href="{{route('regions.create')}}" class="btn btn-primary">Create New +</a>
			</div>
		</div>

		<div class="row mt-3">
			<div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
				<table id="dataTable" class="table table-bordered table-hover">
					<thead class="text-center font-weight-bold">
						
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody class="text-center">

						@php
							$i=1;
						@endphp

						@foreach($regions as $region)

							<tr>
								<td>{{$i++}}</td>
								<td>{{$region->name}}</td>
								<td>
									<button data-id="{{$region->id}}" data-url="{{route('regions.update',$region->id)}}" data-name="{{$region->name}}" class="showModal btn btn-primary" value="Detail" data-toggle="modal" data-target="#mymodal">Edit</button>

									
								</td>
							</tr>

						@endforeach

					</tbody>
				</table>
				
			</div>
		</div>
		
	</div>


	
		
	</div>





	<!-- modal box -->

<div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">

        <h3 class="modal-title font-weight-bold">Edit Region</h3>
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
          				<label class="font-weight-bold">Region Name</label>
          				<input type="text" name="name" class="form-control text-capitalize @error('name') @enderror" id="name">
          				@error('name')
		    				<div class="alert alert-danger">{{ $message }}</div>
						@enderror
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