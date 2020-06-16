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
                                <th class="text-center">IDUSTRIAL OXYGEN</th>
                                <th class="text-center">MEDICAL OXYGEN(FLASK)</th>
                                <th class="text-center">MEDICAL OXYGEN(STANDARD)</th>
                                <th class="text-center">NITROGEN</th>
                                <th class="text-center">ARGON</th>
                                <th class="text-center">OTHER CHARGES</th>
                                <th class="text-center">TOTAL</th>

                            </tr>
                            </thead>
                            <tbody class="text-center">

                                @if($data2 == "empty" && $data != "empty")

                                    @foreach($data as $data)
                                        <tr>
                                            <td> {{ $data['INVOICE_NO'] }}</td>
                                            <td> {{ $data['INVOICE_DATE'] }}</td>
                                            <td> {{ $data['PO_NO'] }}</td>
                                            <td> {{ $data['C2H2'] }} </td>
                                            <td> {{ $data['IO2'] }} </td>
                                            <td> {{ $data['MO2F'] }} </td>
                                            <td> {{ $data['MO2S'] }} </td>
                                            <td> {{ $data['N2'] }} </td>
                                            <td> {{ $data['AR'] }}</td>
                                            <td> {{ $data['OTHER_CHARGES'] }}</td>
                                            <td> {{ $data['TOTAL'] }}</td>
                                        </tr>
                                    @endforeach




                                @elseif($data == "empty" && $data2 != "empty")

                                    @foreach($data2 as $data2)
                                        <tr>
                                            <td> {{ $data2['INVOICE_NO'] }}</td>
                                            <td> {{ $data2['INVOICE_DATE'] }}</td>
                                            <td> {{ $data2['PO_NO'] }} </td>
                                            <td> {{ $data2['C2H2'] }} </td>
                                            <td> {{ $data2['IO2'] }} </td>
                                            <td> {{ $data2['MO2F'] }} </td>
                                            <td> {{ $data2['MO2S'] }} </td>
                                            <td> {{ $data2['N2'] }} </td>
                                            <td> {{ $data2['AR'] }}</td>
                                            <td> {{ $data2['OTHER_CHARGES'] }} </td>
                                            <td> {{ $data2['TOTAL'] }}</td>
                                        </tr>
                                    @endforeach

                                @elseif($data2 == "empty" && $data == "empty")
                                @else

                                    @foreach($data2 as $data2)
                                        <tr>
                                            <td> {{ $data2['INVOICE_NO'] }}</td>
                                            <td> {{ $data2['INVOICE_DATE'] }}</td>
                                            <td> {{ $data2['PO_NO'] }} </td>
                                            <td> {{ $data2['C2H2'] }} </td>
                                            <td> {{ $data2['IO2'] }} </td>
                                            <td> {{ $data2['MO2F'] }} </td>
                                            <td> {{ $data2['MO2S'] }} </td>
                                            <td> {{ $data2['N2'] }} </td>
                                            <td> {{ $data2['AR'] }}</td>
                                            <td> {{ $data2['OTHER_CHARGES'] }} </td>
                                            <td> {{ $data2['TOTAL'] }}</td>
                                        </tr>
                                    @endforeach

                                    @foreach($data as $data)
                                        <tr>
                                            <td> {{ $data['INVOICE_NO'] }}</td>
                                            <td> {{ $data['INVOICE_DATE'] }}</td>
                                            <td> {{ $data['PO_NO'] }}</td>
                                            <td> {{ $data['C2H2'] }} </td>
                                            <td> {{ $data['IO2'] }} </td>
                                            <td> {{ $data['MO2F'] }} </td>
                                            <td> {{ $data['MO2S'] }} </td>
                                            <td> {{ $data['N2'] }} </td>
                                            <td> {{ $data['AR'] }}</td>
                                            <td> {{ $data['OTHER_CHARGES'] }}</td>
                                            <td> {{ $data['TOTAL'] }}</td>
                                        </tr>
                                    @endforeach

                                @endif


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
                    {
                        extend: 'pdfHtml5',
                        orientation: 'portrait',
                        pageSize: 'LEGAL'
                    }
                ]
            } );

        } );
    </script>

@endsection
