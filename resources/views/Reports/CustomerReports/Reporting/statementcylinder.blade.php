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
                @foreach($reportdata as $data)
                @endforeach
                <div class="box-body">
                    <div class="box-body table-responsive">
                        <table id="salesInvoice" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">INVOICE DATE</th>
                                    <th class="text-center">INVOICE NO</th>
                                    <th class="text-center">CLC NO</th>
                                    <th class="text-center">ICR NO</th>
                                    <th class="text-center">C2H2_PRESTOLITE_DELIVER</th>
                                    <th class="text-center">C2H2_PRESTOLITE_PICKUP</th>
                                    <th class="text-center">C2H2_PRESTOLITE_BALANCE</th>
                                    <th class="text-center">C2H2_MEDIUM_DELIVER</th>
                                    <th class="text-center">C2H2_MEDIUM_PICKUP</th>
                                    <th class="text-center">C2H2_MEDIUM_BALANCE</th>
                                    <th class="text-center">C2H2_STANDARD_DELIVER</th>
                                    <th class="text-center">C2H2_STANDARD_PICKUP</th>
                                    <th class="text-center">C2H2_STANDARD_BALANCE</th>
                                    <th class="text-center">AR_STANDARD_DELIVER</th>
                                    <th class="text-center">AR_STANDARD_PICKUP</th>
                                    <th class="text-center">AR_STANDARD_BALANCE</th>
                                    <th class="text-center">CO2_FLASK_DELIVER</th>
                                    <th class="text-center">CO2_FLASK_PICKUP</th>
                                    <th class="text-center">CO2_FLASK_BALANCE</th>
                                    <th class="text-center">CO2_STANDARD_DELIVER</th>
                                    <th class="text-center">CO2_STANDARD_PICKUP</th>
                                    <th class="text-center">CO2_STANDARD_BALANCE</th>
                                    <th class="text-center">IO2_FLASK_DELIVER</th>
                                    <th class="text-center">IO2_FLASK_PICKUP</th>
                                    <th class="text-center">IO2_FLASK_BALANCE</th>
                                    <th class="text-center">IO2_MEDIUM_DELIVER</th>
                                    <th class="text-center">IO2_MEDIUM_PICKUP</th>
                                    <th class="text-center">IO2_MEDIUM_BALANCE</th>
                                    <th class="text-center">IO2_STANDARD_DELIVER</th>
                                    <th class="text-center">IO2_STANDARD_PICKUP</th>
                                    <th class="text-center">IO2_STANDARD_BALANCE</th>
                                    <th class="text-center">LPG_11KG_DELIVER</th>
                                    <th class="text-center">LPG_11KG_PICKUP</th>
                                    <th class="text-center">LPG_11KG_BALANCE</th>
                                    <th class="text-center">LPG_22KG_DELIVER</th>
                                    <th class="text-center">LPG_22KG_PICKUP</th>
                                    <th class="text-center">LPG_22KG_BALANCE</th>
                                    <th class="text-center">LPG_50KG_DELIVER</th>
                                    <th class="text-center">LPG_50KG_PICKUP</th>
                                    <th class="text-center">LPG_50KG_BALANCE</th>
                                    <th class="text-center">MO2_FLASK_DELIVER</th>
                                    <th class="text-center">MO2_FLASK_PICKUP</th>
                                    <th class="text-center">MO2_FLASK_BALANCE</th>
                                    <th class="text-center">MO2_MEDIUM_DELIVER</th>
                                    <th class="text-center">MO2_MEDIUM_PICKUP</th>
                                    <th class="text-center">MO2_MEDIUM_BALANCE</th>
                                    <th class="text-center">MO2_STANDARD_DELIVER</th>
                                    <th class="text-center">MO2_STANDARD_PICKUP</th>
                                    <th class="text-center">MO2_STANDARD_BALANCE</th>
                                    <th class="text-center">N2_FLASK_DELIVER</th>
                                    <th class="text-center">N2_FLASK_PICKUP</th>
                                    <th class="text-center">N2_FLASK_BALANCE</th>
                                    <th class="text-center">N2_STANDARD_DELIVER</th>
                                    <th class="text-center">N2_STANDARD_PICKUP</th>
                                    <th class="text-center">N2_STANDARD_BALANCE</th>
                                    <th class="text-center">N2O_FLASK_DELIVER</th>
                                    <th class="text-center">N2O_FLASK_PICKUP</th>
                                    <th class="text-center">N2O_FLASK_BALANCE</th>
                                    <th class="text-center">N2O_STANDARD_DELIVER</th>
                                    <th class="text-center">N2O_STANDARD_PICKUP</th>
                                    <th class="text-center">N2O_STANDARD_BALANCE</th>
                                    <th class="text-center">H_STANDARD_DELIVER</th>
                                    <th class="text-center">H_STANDARD_PICKUP</th>
                                    <th class="text-center">H_STANDARD_BALANCE</th>
                                    <th class="text-center">COMPMED_STANDARD_DELIVER</th>
                                    <th class="text-center">COMPMED_STANDARD_PICKUP</th>
                                    <th class="text-center">COMPMED_STANDARD_BALANCE</th>
                                </tr>

                            </thead>
                            <tbody class="text-center valueBody">
                                @foreach($reportdata as $data)
                                    <tr>
                                        <td class="text-center">{{$data -> INVOICE_DATE}}</td>
                                        <td class="text-center">{{$data -> INVOICE_NO}}</td>
                                        <td class="text-center">{{$data ->CLC_NO}}</td>
                                        <td class="text-center">{{$data ->ICR_NO}}</td>
                                        <td class="text-center">{{$data -> C2H2_PRESTOLITE_DELIVER}}</td>
                                        <td class="text-center">{{$data -> C2H2_PRESTOLITE_PICKUP}}</td>
                                        <td class="text-center">{{$data -> C2H2_PRESTOLITE_BALANCE}}</td>
                                        <td class="text-center">{{$data -> C2H2_MEDIUM_DELIVER}}</td>
                                        <td class="text-center">{{$data -> C2H2_MEDIUM_PICKUP}}</td>
                                        <td class="text-center">{{$data -> C2H2_MEDIUM_BALANCE}}</td>
                                        <td class="text-center">{{$data -> C2H2_STANDARD_DELIVER}}</td>
                                        <td class="text-center">{{$data -> C2H2_STANDARD_PICKUP}}</td>
                                        <td class="text-center">{{$data -> C2H2_STANDARD_BALANCE}}</td>
                                        <td class="text-center">{{$data -> AR_STANDARD_DELIVER}}</td>
                                        <td class="text-center">{{$data -> AR_STANDARD_PICKUP}}</td>
                                        <td class="text-center">{{$data -> AR_STANDARD_BALANCE}}</td>
                                        <td class="text-center">{{$data -> CO2_FLASK_DELIVER}}</td>
                                        <td class="text-center">{{$data -> CO2_FLASK_PICKUP}}</td>
                                        <td class="text-center">{{$data -> CO2_FLASK_BALANCE}}</td>
                                        <td class="text-center">{{$data -> CO2_STANDARD_DELIVER}}</td>
                                        <td class="text-center">{{$data -> CO2_STANDARD_PICKUP}}</td>
                                        <td class="text-center">{{$data -> CO2_STANDARD_BALANCE}}</td>
                                        <td class="text-center">{{$data -> IO2_FLASK_DELIVER}}</td>
                                        <td class="text-center">{{$data -> IO2_FLASK_PICKUP}}</td>
                                        <td class="text-center">{{$data -> IO2_FLASK_BALANCE}}</td>
                                        <td class="text-center">{{$data -> IO2_MEDIUM_DELIVER}}</td>
                                        <td class="text-center">{{$data -> IO2_MEDIUM_PICKUP}}</td>
                                        <td class="text-center">{{$data -> IO2_MEDIUM_BALANCE}}</td>
                                        <td class="text-center">{{$data -> IO2_STANDARD_DELIVER}}</td>
                                        <td class="text-center">{{$data -> IO2_STANDARD_PICKUP}}</td>
                                        <td class="text-center">{{$data -> IO2_STANDARD_BALANCE}}</td>
                                        <td class="text-center">{{$data -> LPG_11KG_DELIVER}}</td>
                                        <td class="text-center">{{$data -> LPG_11KG_PICKUP}}</td>
                                        <td class="text-center">{{$data -> LPG_11KG_BALANCE}}</td>
                                        <td class="text-center">{{$data -> LPG_22KG_DELIVER}}</td>
                                        <td class="text-center">{{$data -> LPG_22KG_PICKUP}}</td>
                                        <td class="text-center">{{$data -> LPG_22KG_BALANCE}}</td>
                                        <td class="text-center">{{$data -> LPG_50KG_DELIVER}}</td>
                                        <td class="text-center">{{$data -> LPG_50KG_PICKUP}}</td>
                                        <td class="text-center">{{$data -> LPG_50KG_BALANCE}}</td>
                                        <td class="text-center">{{$data -> MO2_FLASK_DELIVER}}</td>
                                        <td class="text-center">{{$data -> MO2_FLASK_PICKUP}}</td>
                                        <td class="text-center">{{$data -> MO2_FLASK_BALANCE}}</td>
                                        <td class="text-center">{{$data -> MO2_MEDIUM_DELIVER}}</td>
                                        <td class="text-center">{{$data -> MO2_MEDIUM_PICKUP}}</td>
                                        <td class="text-center">{{$data -> MO2_MEDIUM_BALANCE}}</td>
                                        <td class="text-center">{{$data -> MO2_STANDARD_DELIVER}}</td>
                                        <td class="text-center">{{$data -> MO2_STANDARD_PICKUP}}</td>
                                        <td class="text-center">{{$data -> MO2_STANDARD_BALANCE}}</td>
                                        <td class="text-center">{{$data -> N2_FLASK_DELIVER}}</td>
                                        <td class="text-center">{{$data -> N2_FLASK_PICKUP}}</td>
                                        <td class="text-center">{{$data -> N2_FLASK_BALANCE}}</td>
                                        <td class="text-center">{{$data -> N2_STANDARD_DELIVER}}</td>
                                        <td class="text-center">{{$data -> N2_STANDARD_PICKUP}}</td>
                                        <td class="text-center">{{$data -> N2_STANDARD_BALANCE}}</td>
                                        <td class="text-center">{{$data -> N2O_FLASK_DELIVER}}</td>
                                        <td class="text-center">{{$data -> N2O_FLASK_PICKUP}}</td>
                                        <td class="text-center">{{$data -> N2O_FLASK_BALANCE}}</td>
                                        <td class="text-center">{{$data -> N2O_STANDARD_DELIVER}}</td>
                                        <td class="text-center">{{$data -> N2O_STANDARD_PICKUP}}</td>
                                        <td class="text-center">{{$data -> N2O_STANDARD_BALANCE}}</td>
                                        <td class="text-center">{{$data -> H_STANDARD_DELIVER}}</td>
                                        <td class="text-center">{{$data -> H_STANDARD_PICKUP}}</td>
                                        <td class="text-center">{{$data -> H_STANDARD_BALANCE}}</td>
                                        <td class="text-center">{{$data -> COMPMED_STANDARD_DELIVER}}</td>
                                        <td class="text-center">{{$data -> COMPMED_STANDARD_PICKUP}}</td>
                                        <td class="text-center">{{$data -> COMPMED_STANDARD_BALANCE}}</td>
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
                "scrollX": true,
                "paging":   false,
                "ordering": false,
                "info":     false
            } );

        } );

        var td1 = 0;

        $('.valueBody').each(function () {
            td1 = td1 + parseFloat($(this).find('.td1').text());
        })


    </script>

@endsection
