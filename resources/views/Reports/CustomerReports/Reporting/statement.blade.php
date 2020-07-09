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
                            <tbody class="text-center valueBody">

                                @if($sales_data != "empty" && $dr_data != "empty")

                                    @for($i = 0; $i < count($sales_data) ; $i++)
                                        @foreach($sales_data[$i] as $value)
                                            <tr>
                                                <td> {{ $value['INVOICE_NO'] }}</td>
                                                <td> {{ $value['INVOICE_DATE'] }}</td>
                                                <td> {{ $value['PO_NO'] }} </td>
                                                <td class="td1">{{ $value['C2H2'] }}</td>
                                                <td class="td2">{{ $value['IO2'] }}</td>
                                                <td class="td3">{{ $value['MO2F'] }}</td>
                                                <td class="td4">{{ $value['MO2S'] }}</td>
                                                <td class="td5">{{ $value['N2'] }}</td>
                                                <td class="td6">{{ $value['AR'] }}</td>
                                                <td class="td7">{{ $value['OTHER_CHARGES'] }}</td>
                                                <td class="td8">{{ $value['TOTAL'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endfor

                                    @for($i = 0; $i < count($dr_data) ; $i++)
                                        @foreach($dr_data[$i] as $value)
                                            <tr>
                                                <td> {{ $value['DR_NO'] }}</td>
                                                <td> {{ $value['DR_DATE'] }}</td>
                                                <td> {{ $value['PO_NO'] }} </td>
                                                <td class="td1">{{ $value['C2H2'] }}</td>
                                                <td class="td2">{{ $value['IO2'] }}</td>
                                                <td class="td3">{{ $value['MO2F'] }}</td>
                                                <td class="td4">{{ $value['MO2S'] }} </td>
                                                <td class="td5">{{ $value['N2'] }} </td>
                                                <td class="td6">{{ $value['AR'] }}</td>
                                                <td class="td7">{{ $value['OTHER_CHARGES'] }}</td>
                                                <td class="td8">{{ $value['TOTAL'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endfor

                                @elseif($sales_data != "empty")
                                    @for($i = 0; $i < count($sales_data) ; $i++)
                                        @foreach($sales_data[$i] as $value)
                                            <tr>
                                                <td> {{ $value['INVOICE_NO'] }}</td>
                                                <td> {{ $value['INVOICE_DATE'] }}</td>
                                                <td> {{ $value['PO_NO'] }} </td>
                                                <td class="td1">{{ $value['C2H2'] }}</td>
                                                <td class="td2">{{ $value['IO2'] }}</td>
                                                <td class="td3">{{ $value['MO2F'] }}</td>
                                                <td class="td4">{{ $value['MO2S'] }}</td>
                                                <td class="td5">{{ $value['N2'] }}</td>
                                                <td class="td6">{{ $value['AR'] }}</td>
                                                <td class="td7">{{ $value['OTHER_CHARGES'] }}</td>
                                                <td class="td8">{{ $value['TOTAL'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endfor

                                @elseif($dr_data != "empty")
                                    @for($i = 0; $i < count($dr_data) ; $i++)
                                        @foreach($dr_data[$i] as $value)
                                            <tr>
                                                <td> {{ $value['DR_NO'] }}</td>
                                                <td> {{ $value['DR_DATE'] }}</td>
                                                <td> {{ $value['PO_NO'] }} </td>
                                                <td class="td1">{{ $value['C2H2'] }}</td>
                                                <td class="td2">{{ $value['IO2'] }}</td>
                                                <td class="td3">{{ $value['MO2F'] }}</td>
                                                <td class="td4">{{ $value['MO2S'] }}</td>
                                                <td class="td5">{{ $value['N2'] }}</td>
                                                <td class="td6">{{ $value['AR'] }}</td>
                                                <td class="td7">{{ $value['OTHER_CHARGES'] }}</td>
                                                <td class="td8">{{ $value['TOTAL'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endfor
                                    <tfoot>
                                    <tr>
                                        <td></td>
                                        <td>TOTAL</td>
                                        <td></td>
                                        <td class="Totaltd1"> </td>
                                        <td class="Totaltd2"> </td>
                                        <td class="Totaltd3"> </td>
                                        <td class="Totaltd4"> </td>
                                        <td class="Totaltd5"> </td>
                                        <td class="Totaltd6"> </td>
                                        <td class="Totaltd7"> </td>
                                        <td class="Totaltd8"> </td>
                                    </tr>
                                    </tfoot>
                                @else
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
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                orientation: 'landscape',
                pageSize: 'A5'
            } );

        } );

        var td1 = 0;

        $('.valueBody').each(function () {
            td1 = td1 + parseFloat($(this).find('.td1').text());
        })


    </script>

@endsection
