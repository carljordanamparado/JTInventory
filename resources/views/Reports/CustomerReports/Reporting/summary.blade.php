@extends('main')

@section('content')

    <style>
        .btn-validate{
            display:inline-block;
            text-align:center;
        }
        .lbl {
            display:block;
        }
        .select2 {
            width:100%!important;
            height:100%!important;
        }
    </style>

    <div class="content-wrapper">

        <section class="content">
            <div class="box">
                <div class="box-header text-center">
                    <span> Statement of Account </span>
                </div>
                <div class="box-body">
                    <div class="box-body table-responsive">
                        <table id="salesInvoice" class="table table-bordered table-striped">

                            <thead>
                                <tr>
                                    <th class="text-center">REPORT NO</th>
                                    <th class="text-center">REPORT DATE</th>
                                    <th class="text-center">REPORT PO</th>
                                    <th class="text-center">ACETYLENE</th>
                                    <th class="text-center">INDUSTRIAL OXYGEN</th>
                                    <th class="text-center">MEDICAL OXYGEN</th>
                                    <th class="text-center">NITROGEN</th>
                                    <th class="text-center">ARGON</th>
                                    <th class="text-center">OTHER CHARGES</th>
                                    <th class="text-center">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody class="text-center valueBody">
                                @foreach($summary_account as $data)
                                    <tr class="text-center">
                                        <td> {{ $data -> INVOICE_NO }}</td>
                                        <td> {{ $data -> INVOICE_DATE }}</td>
                                        <td> {{ $data -> PO_NO }}</td>
                                        <td> {{ $data ->  C2H2 }}</td>
                                        <td> {{ $data -> IO2 }}</td>
                                        <td> {{ $data -> MO2 }}</td>
                                        <td> {{ $data -> N2 }}</td>
                                        <td> {{ $data -> AR }}</td>
                                        <td> {{ $data -> OTHER_CHARGES }}</td>
                                        <td> {{ $data -> TOTAL }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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

            $('#salesInvoice').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'csv', 'excel', 'print'
                ],
                orientation: 'landscape',
                pageSize: 'A5',
            } );

        } );

        var td1 = 0;

        $('.valueBody').each(function () {
            td1 = td1 + parseFloat($(this).find('.td1').text());
        })


    </script>

@endsection
