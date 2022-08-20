@extends('backendtemplate')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-lg-12 text-center">
				<h1 class="font-weight-bold">Current Stocks</h1>
			</div>
		</div>
		<div class="row">		
					
					<div class="col-md-12 col-lg-12 col-sm-12 my-auto">
						<a href="{{route('stocks.create')}}" class="btn btn-primary">Create New + </a>
					</div>	

					<div class="col-md-12 col-lg-12 col-sm-12">
						<h3>Choose Branch</h3>
						<select class="form-control" id="branch_id" name="branch_id">
							<option>---Choose Branch---</option>
							@foreach($branches as $rows)
							<option value="{{$rows->id}}">{{$rows->name}}</option>
							@endforeach
						</select>
						
					</div>		
			
		</div>
	</div>

	<div class="container">
		<div class="row">
			
			<div class="col-md-12 col-lg-12 table-responsive-md mt-4">
				<table class="table  table-bordered">
					<thead class="text-center">
						<tr>
							<th>No</th>
							<th>Product Name</th>
							<th>Current Stocks</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="products" >
						
					</tbody>
				</table>	
			</div>
			
		</div>
	</div>

	<!-- modal box -->

	<div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">

        <h3 class="modal-title font-weight-bold">Edit Stocks</h3>
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
          				<label class="font-weight-bold">Product Name</label>
          				<input type="text" name="name" class="form-control" id="name" disabled="disabled">
          			</div>
          			<div class="col-lg-12 col-md-12">
          				<label class="font-weight-bold">Quantity</label>
          				<input type="hidden" name="branch_id" id="branchid">
          				<input type="hidden" name="id" id="id">
          				<input type="text" name="quantity" class="form-control" id="quantity">
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

		

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
			}
		});

		$(document).ready(function($) {
			$('#branch_id').change(function(event) {
				var id = $(this).find(":selected").val();

				var id = $(this).find(":selected").val();

				var j = 1;	
				var html = "";

				$.post('/search_stock',{id:id},function(res){
					if(res)	{

						
						var j = 1;
						var html = "";

						$.each(res,function(i,v){
							var id = v.id;

							var product_id = v.product_id;
							var product_name = v.product.name;
							

							var delete_url = '{{route('stocks.destroy',"id")}}';
								delete_url = delete_url.replace('id',id);

							// var subcategory_name = v.subcategory.name;

							var current_stock = v.quantity;

							html +=`
								<tr>
									<td>${j++}</td>
									<td>${product_name}</td>
									
									<td>
										${current_stock}

									</td>
									<td>
									
										<button data-id="${id}" data-name="${product_name}" data-quantity="${current_stock}" class="showModal btn btn-primary" value="Detail" data-toggle="modal" data-target="#mymodal">Edit</button>

										
									</td>
								</tr>
								`
								html=html.replace(':id',v.id);
						})
						$('#products').html(html);
					}

				})
			});

			$('#mymodal').on('show.bs.modal', function (event) {
			  var button = $(event.relatedTarget) // Button that triggered the modal
			  var name = button.data('name')
			  
			  var id = button.data('id')
			  var quantity = button.data('quantity')
			  var edit_url = '{{route('stocks.update',":id")}}';
				edit_url = edit_url.replace(':id',id);

			  var branch_id = $('#branch_id').find(":selected").val();
			   
			  var modal = $(this)
			  
			  modal.find('.modal-body #name').val(name);
			  modal.find('.modal-body #branchid').val(branch_id);
			  modal.find('.modal-body #id').val(id);
			  modal.find('.modal-body #quantity').val(quantity);
			  modal.find('.modal-body form').attr("action",edit_url);
			})


		});

	</script>

@endsection