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
                    <div class="col-md-2">
                        <a type="button" class="btn btn-success btn-md" href="{{ route('PurchaseOrderController.create') }}"> Add Purchase Order </a>
                 </div>
                </div>
              <div class="box-body table-responsive">
                        <table id="customerTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Client Code</th>
                                    <th>Customer Name</th>
                                    <th>PO NO.</th>
                                    <th>PO DATE</th>
                                    <th>STATUS</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchaselist as $purchaselist)
                                    <tr>
                                        <td>{{ $purchaselist -> CLIENT_CODE }}</td>
                                        <td>{{ $purchaselist -> NAME }}</td>
                                        <td>{{ $purchaselist -> PO_NO }}</td>
                                        <td>{{ $purchaselist -> PO_DATE }}</td>
                                        @if($purchaselist -> STATUS == 1)
                                            <td> ACTIVE </td>
                                        @elseif($purchaselist -> STATUS == 2)
                                            <td> INACTIVE </td>
                                        @endif
                                        <td class="text-center">
                                            <div class="btn-group-vertical">
                                                <a type="button" class="btn btn-info" href="{{ route('PurchaseOrderController.show', $purchaselist->PO_NO) }}"><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                                             {{--   <a type="button" class="btn btn-warning"><span class="fa fa-trash">&nbsp;&nbsp;</span>Delete</a>--}}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
            });



        });

    </script>
@endsection