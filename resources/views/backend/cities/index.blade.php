@extends('backendtemplate')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 text-center">
				<h1><u>Cities Table</u></h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<a href="{{route('cities.create')}}" class="btn btn-primary float-left mb-3">Add New +</a>
			</div>
			<div class="col-lg-12 table-responsive">
				<table id="data_table" class="table table-striped table-bordered">
					<thead class="text-center">
						
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Region Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody class="text-center">
						<?php $i=1; ?>
						<?php foreach ($cities as $row): ?>
							<tr>
								<td>{{$i++}}</td>
								<td>{{$row->name}}</td>
								<td>{{$row->region->name}}</td>
								<td>
									
									<button data-id="{{$row->id}}" data-url="{{route('cities.update',$row->id)}}" data-region="{{$row->region_id}}" data-url="{{route('cities.update',$row->id) }}" data-name="{{$row->name}}" class="showModal btn btn-primary" value="Detail" data-toggle="modal" data-target="#mymodal">Edit</button>

									
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>

		</div>
	</div>

	<div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">

        <h3 class="modal-title font-weight-bold">Edit Subcategory</h3>
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
          			<div class="col-md-12 col-lg-12">
          				
          				<label>Region</label>
						<select id="region_id" name="region_id" class="form-control @error ('region_id') @enderror">
							<option value="" disabled="">--- Choose Region ---</option>
							@foreach($regions as $row)

								<option value="{{$row->id}}">{{$row->name}}</option>

							@endforeach
						</select>
						@error('category_id')
		    				<div class="alert alert-danger">{{ $message }}</div> 	
						@enderror
          			</div>
          			<div class="col-lg-12 col-md-12">
          				<label class="font-weight-bold">City Name</label>
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
			  var region = button.data('region');

			  // console.log(category);
			  $(".modal-body select").val(region);
			  // $(".modal-body #region").select2();
			  	   
			  var modal = $(this)	  
			  modal.find('.modal-body #name').val(name);
			  modal.find('.modal-body form').attr("action",url);
			})
		});	
	</script>
		

@endsection