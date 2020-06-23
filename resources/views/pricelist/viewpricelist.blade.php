@extends('main')



@section('content')

    <style>

        .dataTables_wrapper .dataTables_length {
            float: left;
        }
        .dataTables_wrapper .dataTables_filter {
            float: right;
            text-align: right;
        }
        .addCustomer{

        }

    </style>

    <div class="content-wrapper">

        <section class="content">

            <div class="box">
                <div class="box-header">
                    @if( Session::get('status') == "True" )
                        <input type="text" id="notifAlert" value="1">
                    @endif
                    @if( Session::get('statusUpdate') == "True" )
                        <input type="text" id="updateNotif" value="1">
                    @endif
                </div>
                <div class="box-body">
                    <div class="row-content">
                        <div class="col-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="bpx-title">Customer List </h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="box-body table-responsive">
                                    <table id="customerTable" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>Client ID</th>
                                            <th>Customer Name</th>
                                            <th>Customer Type</th>
                                            <th>Address</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($client as $row)
                                            <tr>
                                                <td>{{ $row -> CLIENTID }}</td>
                                                <td>{{ $row -> NAME }}</td>
                                                <td>{{ $row -> CLIENT_TYPE }}</td>
                                                <td>{{ $row -> ADDRESS }}</td>
                                                <td class="text-center"><div class="btn-group-vertical">
                                                        <a type="button" class="btn btn-primary" href="{{ route('PriceController.create', $row->CLIENTID) }}"><span class="fa fa-plus">&nbsp;&nbsp;</span>View Product Price</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>

                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </section>

    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $('#customerTable').DataTable({
                "paging":   true,
                "info":     true,
                "ordering": true,
                'searching': true,

            });

            var statusAlert = $('#notifAlert').val();

            if(statusAlert == "1"){
                swal("Customer Information is Successfully Added", "", "success");
            }

        });

    </script>
@endsection