<!DOCTYPE html>
<html>
<head>

	<title></title>

	<meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	  <meta name="description" content="">
	  <meta name="author" content="">
	  <meta name="csrf-token" content="{{ csrf_token() }}">

	  <title>SB Admin 2 - Dashboard</title>

	  <!-- Select 2 -->
	  <link href="{{asset('select2/dist/css/select2.min.css')}}" rel="stylesheet" />
	  

	  <!-- Custom fonts for this template-->
	  <link href="{{asset('admindashboard/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
	  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

	   <link href="{{ asset('sb_admin/dist/css/styles.css')}}" rel="stylesheet" />
	   <link href="{{ asset('sb_admin/dist/css/custom.css')}}" rel="stylesheet" />
	   <link href="{{ asset('admindashboard/css/jquery-ui.css')}}" rel="stylesheet" />

	  



	  <!-- Custom styles for this template-->
	  <link href="{{asset('admindashboard/css/sb-admin-2.min.css')}}" rel="stylesheet">

	  
	  <!-- Custom styles for this page -->
	  <link href="{{asset('admindashboard/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
</head>
<body>
	<form method="post" action="{{route('sales.store')}}" id="jsPrint">
		@csrf
	<div class="container-fluid logo-border">
		<div class="row ">
			<div class="col-md-4 col-lg-4 col-sm-4">
				<img src="{{asset('images/logo.png')}}" class="img">
			</div>
			<div class="col-md-8 col-sm-8 col-lg-8 text-center my-auto">
				<h1 class="logo-title">Power 9 Plus Company Limited</h1>
				<h4><span class="logo-title">Electrical Product and Accessories Distribution</span></h4>
			</div>
		</div>

		<div class="row">
			<div class="col-md-3 col-lg-3 col-sm-3">
				<span class="logo-address-title">Yangon Address</span>
			</div>
			<div class="col-md-9 col-lg-9 col-sm-9">
				<span class="logo-address">No.240, Khaymar Thi Road, Talalinjake quarter, North Okkalapa Township, Yangon.</span>	
			</div>
		</div>

		<div class="row row-address">
			<div class="col-md-3 col-lg-3 col-sm-3">
				<span class="logo-address-title">Mandalay Address</span>
			</div>
			<div class="col-md-9 col-lg-9 col-sm-9">
				<span class="logo-address">No.4/4, Myasandar Street, Between (24x25) and (62x63), Manadalay.</span>	
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 text-center logo-address-title" style="margin: 0;">
				<span>(MDY) <i class="fas fa-phone"></i> +959 459834013</span>&nbsp;&nbsp;
				<span>(YGN) <i class="fas fa-phone"></i> +959 794252605</span>
				<span class="logo-email">Email <i class="fas fa-envelope-open-text"></i> &nbsp;&nbsp;power9plus@gmail.com</span>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 col-sm-6 col-lg-6 text-center">
				<span class="cust-lable">အမည် Customer</span> - <span><u>{{$customer->name}}</u></span>
			</div>
			<div class="col-md-6 col-sm-6 col-lg-6">
				<span class="cust-lable">ကုန်ပို့ ပြေစာအမှတ် Delivery Form No</span> - <span><u>{{$voucher_no}}</u></span>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 col-sm-6 col-lg-6 text-center">
				<span class="cust-lable">လိပ်စာ Address</span> - <span><u>{{$customer->address}}</u></span>
			</div>
			<div class="col-md-6 col-sm-6 col-lg-6">
				<span class="cust-lable">နေ့စွဲ Date</span> - <span><u>{{$today_date}}</u></span>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
				<table class="table tble">
					<thead class="text-center tble">
						<tr class="cust-lable">
							<th>စဥ်<br>
								No
							</th>
							<th>
								အကြောင်းအရာ <br>
								Description
							</th>
							<th>
								အရေအတွက် <br>
								Qauntity
							</th>
							<th>
								နှုန်း <br>
								Price
							</th>
							<th>
								သင့်ငွေ <br>
								Amount
							</th>
						</tr>
					</thead>
					<tbody class="text-center">
						@php
							$count = count($product_id);
						@endphp

						@for($i=0 ; $i < $count; $i++)
							<tr>
								<td>{{$i+1}}.</td>
								<td>{{$product_name[$i]}}</td>
								<td>{{$quantity[$i]}}</td>
								<td>{{$sale_price[$i]}}</td>
								<td>{{$amount[$i]}}</td>
							</tr>
						@endfor
						
						@for($j=0 ; $j < 2 ; $j++)
							<tr>
								<td colspan="5"></td>
							</tr>
						@endfor

						<!-- promotion area -->
						@php $count = count($promo_product_id); @endphp
						@if($count > 0)
							<tr>
								<td colspan="5">
									<h2>Promotion Items</h2>
								</td>
							</tr>
							@for($i=0;$i<$count; $i++)
								<tr>
									<td>{{$i+1}}</td>
									<td>{{$promo_product_name[$i]}}</td>
									<td>{{$promo_quantity[$i]}}</td>
									<td colspan="2"></td>
								</tr>
							@endfor
						@endif

							@if($method == 'credit')
								<tr>
									<td colspan="5" class="text-capitalize"><h2>One Month Credit Payment</h2></td>
								</tr>
								@elseif($method == '1week')
									<tr>
										<td colspan="5" class="text-capitalize"><h2>1 Week Credit Payment</h2></td>
									</tr>
								@elseif($method == '2week')
									<tr>
										<td colspan="5" class="text-capitalize"><h2>2 Week Credit Payment</h2></td>
									</tr>
								@elseif($method == 'cash')
									<tr>
										<td colspan="5" class="text-capitalize"><h2>Cash Payment</h2></td>
									</tr>

							@endif

							<tr>
								<td colspan="4" class="cust-lable">Total Amount</td>
								<td>{{$total_amount}}</td>
							</tr>

							@if($discount != null)
								<tr>
									<td colspan="4" class="cust-lable">Discount Amount</td>
									<td>{{$discount_amount}}</td>
								</tr>
							@endif

							@if($bonus != null)
								<tr>
									<td colspan="4" class="cust-lable">Bonus Amount</td>
									<td>{{$bonus}}</td>
								</tr>
							@endif

								<tr>
									<td colspan="4" class="cust-lable">Balance</td>
									<td>{{$balance}}</td>
								</tr>



					</tbody>
				</table>
			</div>
		</div> <!-- end of row  -->

		<div class="row blank-div">
			
		</div>

		<div class="row text-center">
			<div class="col-md-4 col-lg-4 col-sm-4">
				<h6 class="cust-lable">လက်ခံ ရရှိသူ<br>
					(Received By)
				</h6>
			</div>

			<div class="col-md-4 col-lg-4 col-sm-4">
				<h6 class="cust-lable">စာရင်းကိုင်<br>
					(Accountant)
				</h6>
			</div>

			<div class="col-md-4 col-lg-4 col-sm-4">
				<h6 class="cust-lable">ပေးပို့သူ<br>
					(Delivered By)
				</h6>
			</div>
		</div>

	</div>

	
		<div class="container">
			<div class="row my-2 mb-4">
				
					

						<!-- hidden part -->
						<input type="hidden" name="customer_id" value="{{$customer->id}}">
						<input type="hidden" name="method" value="{{$method}}">
						<input type="hidden" name="discount" value="{{$discount}}">
						<input type="hidden" name="bonus" value="{{$bonus}}">
						<input type="hidden" name="branch_id" value="{{$branch_id}}">
						<input type="hidden" name="balance" value="{{$balance}}">
						<input type="hidden" name="voucher_no" value="{{$voucher_no}}">
						<input type="hidden" name="total_amount" value="{{$total_amount}}">


						@foreach($product_id as $product)
							<input type="hidden" name="product_id[]" value="{{$product}}">
						@endforeach

						@foreach($quantity as $quan)
							<input type="hidden" name="quantity[]" value="{{$quan}}">
						@endforeach

						@foreach($sale_price as $sale_p)
							<input type="hidden" name="sale_price[]" value="{{$sale_p}}">
						@endforeach

						@foreach($amount as $amoun)
							<input type="hidden" name="amount[]" value="{{$amoun}}">
						@endforeach

						<!-- promotion info -->

						@foreach($promo_product_id as $promo_id)
							<input type="hidden" name="promo_product_id[]" value="{{$promo_id}}">
						@endforeach

						@foreach($promo_quantity as $promo_quantity)
							<input type="hidden" name="promo_quantity[]" value="{{$promo_quantity}}">
						@endforeach

					
						<div class="col-md-4 col-lg-4 col-sm-4">

							<a onclick="history.back();" class="btn btn-primary float-left text-white">Back</a>

						</div>	

					
						<div class="col-md-4 col-lg-4 col-sm-4 text-center">

							<button type="button" onclick="printJS({ printable: 'jsPrint', type: 'html', header: 'PrintJS - Form Element Selection' })" class="btn btn-warning">
							    Print Form
							</button>
							 

						</div>

						<div class="col-md-4 col-lg-4 col-sm-4">
							<input type="submit" class="btn btn-success float-right" value="Save">
						</div>
						
				
			</div>
		</div>
	</form>

	<!-- <button class="printPage"> Print</button> -->
	<a class="printPage">Print</a>
	







	<!-- JAVASCRIPT -->


	<!-- Bootstrap core JavaScript-->
  <script src="{{asset('admindashboard/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('admindashboard/vendor/jquery/jquery-ui.min.js')}}"></script>

  
  <script src="{{asset('admindashboard/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{asset('admindashboard/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{asset('admindashboard/js/sb-admin-2.min.js')}}"></script>

  <!-- Page level plugins -->
  <script src="{{asset('admindashboard/vendor/chart.js/Chart.min.js')}}"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('admindashboard/js/demo/chart-area-demo.js')}}"></script>
  <script src="{{asset('admindashboard/js/demo/chart-pie-demo.js')}}"></script>

  <!-- Data Table -->
  <script src="{{asset('admindashboard/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('admindashboard/vendor/datatables/dataTables.bootstrap4.js')}}"></script>
  

  <script src="{{ asset('sb_admin/dist/js/scripts.js')}}"></script>
  <script src="{{ asset('sb_admin/dist/assets/demo/datatables-demo.js')}}"></script>

  <!-- Select2 -->
  <script src="{{asset('select2/dist/js/select2.min.js')}}"></script>

  <script type="text/javascript">
	
	$(document).ready(function(){
		$('a.printPage').on('click',function(){
			window.print();
			return false;
	  	});
	});

</script>
</body>
</html>

