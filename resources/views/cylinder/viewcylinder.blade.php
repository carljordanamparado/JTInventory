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
                                    <table id="cylinderBalance" class="table table-bordered table-striped">
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
                                                <td class="text-center">
                                                    <div class="btn-group-vertical">
                                                    <a type="button" class="btn btn-primary" href="{{ route('CylinderController.create', $row->CLIENTID)}}"><span class="fa fa-plus">&nbsp;&nbsp;</span>Add Price</a>
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

            $('#cylinderBalance').DataTable({
            });

           

        });

    </script>
@endsection