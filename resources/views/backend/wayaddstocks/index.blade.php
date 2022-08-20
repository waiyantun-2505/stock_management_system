@extends('backendtemplate')

@section('content')
    
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12 text-center my-2">
                <span class="nav-link"><b> <u>Pending Records</u></b></span>
            </div>
            @php $j=1; @endphp
            @foreach($pending_branches as $pending_branch)
                <div class="col-md-12 col-lg-12 col-sm-12 table-responsive">
                            <table class="display" class="table table-bordered table-hover text-center">
                                <thead>
                                    <tr>
                                        <th colspan="4" class="text-center"> {{$pending_branch->branch->name}} </th>
                                    </tr>
                                    <tr>
                                        <th> No </th>
                                        <th> Way Route </th>
                                        <th> Way Add Date </th>
                                        <th> Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                    @php $i=1; @endphp
                    @foreach($pending_records as $record)
                        
                        @if($pending_branch->branch_id == $record->branch_id)
                            <tr>
                                <td> {{ $i++}} </td>
                                <td> {{$record->wayout->way_cities}} </td>
                                <td> {{$record->wayadd_date}} </td>
                                <td> <a href="" class="btn btn-primary"> Detail </a> 
                                     @if($record->send_status == "Pending")
                                        <a href=""> Confirm </a> </td>
                                        @else
                                        <a href=""> Pending </a> </td>
                                     @endif
                            </tr>
                                    
                                
                        @endif
                    @endforeach
                            </tbody>
                        </table>
                    </div>
            @endforeach
        </div>
    </div>

@endsection

@section('script')

    <script>
        
        $(document).ready(function() {
            $('table.display').DataTable();
            } );
    </script>

@endsection