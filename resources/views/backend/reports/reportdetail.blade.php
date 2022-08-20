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
	   <link href="{{ asset('admindashboard/css/jquery-ui.css')}}" rel="stylesheet" />


	  <!-- Custom styles for this template-->
	  <link href="{{asset('admindashboard/css/sb-admin-2.min.css')}}" rel="stylesheet">

	  
	  <!-- Custom styles for this page -->
	  <link href="{{asset('admindashboard/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
</head>
<body>
	<div class="container-fluid">
		
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 text-center">
				<h1>{{$info[0]}} - {{$info[1]}}-{{$info[2]}} (Monthly Report)</h1>
			</div>
			<div class="col-md-12 col-lg-12 col-sm-12">
				<a href="{{route('report')}}" class="btn btn-danger">Back</a>
				<button class="btn btn-success float-right" onclick="window.print()">Print Preview</button>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
				
				<table class="table table-bordered table-hover">
					
					<thead class="text-center">
						<tr>
							<th rowspan="2">
								
							</th>
							<th rowspan="2">
								
							</th>
							<th rowspan="2">
								Order Amount
							</th>
							<th rowspan="2">
								Way Sale
							</th>
							<th rowspan="2">
								testing
							</th>
							
						
							@foreach($stocks as $stock)
								<tr>
									<td>{{$stock->product->name}}</td>
								</tr>
							@endforeach
							
							
						</tr>
					</thead>

				</table>

			</div>
		</div>

	</div>







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
</body>
</html>

