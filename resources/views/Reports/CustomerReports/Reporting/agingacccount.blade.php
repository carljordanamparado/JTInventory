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
                    <span> Aging of Account </span>
                </div>
                <div class="box-body">
                    <div class="box-body table-responsive">
                        <table id="salesInvoice" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">REPORT NO</th>
                                    <th class="text-center">REPORT DATE</th>
                                    <th class="text-center">BELOW 30</th>
                                    <th class="text-center">WITHIN 30 AND 60</th>
                                    <th class="text-center">WITHIN 60 AND 90</th>
                                    <th class="text-center">WITHIN 90 AND 120</th>
                                    <th class="text-center">ABOVE 120</th>
                                    <th class="text-center">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach($Aging as $data)
                                    <tr>
                                        <td> {{ $data -> REPORTNO }}</td>
                                        <td> {{ $data -> REPORTDATE }}</td>
                                        <td>
                                            @if($data -> AGING <= 30)
                                                {{ $data -> BALANCE }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($data -> AGING > 30 && $data -> AGING <= 60)
                                                {{ $data -> BALANCE }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($data -> AGING > 60 && $data -> AGING <= 90)
                                                {{ $data -> BALANCE }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($data -> AGING > 90 && $data->AGING <= 120)
                                                {{ $data -> BALANCE }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($data -> AGING > 120)
                                                {{ $data -> BALANCE }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            {{ $data -> BALANCE }}
                                        </td>
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
    </script>

@endsection
