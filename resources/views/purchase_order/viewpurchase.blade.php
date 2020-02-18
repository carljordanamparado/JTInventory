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
            </div>
            <!-- /.row -->
        </section>

    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $('#purchaseOrder').DataTable({
            });



        });

    </script>
@endsection