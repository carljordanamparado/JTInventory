@extends('main')

@section('content')
    <style>
        .select2 {
            width:100%!important;
        }
    </style>

    <div class="content-wrapper">
        <section class="content">
            <div class="box">
                <div class="box-header text-center">
                    <span> Delivery Receipt </span>
                    {{--               <a href="{{ route('SalesInvoice.create') }}" class="btn btn-block btn-primary btn-flat addCustomer pull-right"> Add Sales Invoice Declaration </a>--}}
                </div>
                <div class="box-body">
                        <div class="tabbable-panel">
                            <div class="tabbable-line">
                                <ul class="nav nav-tabs ">
                                    <li class="active">
                                        <a href="#tab_default_1" data-toggle="tab"> Delivery As Invoice </a>
                                    </li>
                                    <li>
                                        <a href="#tab_default_2" data-toggle="tab"> Delivery  </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_default_1">
                                        <div class="box-header text-center">
                                            <a href="{{ route('DeliverSales.create') }}" class="btn btn-block btn-primary btn-flat addCustomer pull-right"> Add Delivery as Invoice</a>
                                        </div>
                                        <div class="box-body table-responsive">
                                            <table id="deliveryInvoice" class="table table-bordered table-striped">
                                                <thead>
                                                <th class="text-center"> Delivery No. </th>
                                                <th class="text-center"> Delivery Date. </th>
                                                <th class="text-center"> Customer Name </th>
                                                <th class="text-center"> Actions </th>
                                                </thead>
                                                <tbody>
                                                @foreach($deliver_invoice as $deliver_invoice)
                                                    <tr class="text-center">
                                                        <td> {{ $deliver_invoice -> DR_NO }}</td>
                                                        <td> {{ $deliver_invoice -> DR_DATE }}</td>
                                                        <td> {{ $deliver_invoice -> NAME }}</td>
                                                        <td><a type="button" class="btn btn-info" href=""><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_default_2">
                                        <div class="box-header text-center">
                                            <a href="{{ route('Deliver.create') }}" class="btn btn-block btn-primary btn-flat addCustomer pull-right"> Add Delivery </a>
                                        </div>
                                        <div class="box-body table-responsive">
                                            <table id="delivery" class="table table-bordered table-striped">
                                                <thead>
                                                    <th class="text-center"> Delivery No. </th>
                                                    <th class="text-center"> Delivery Date. </th>
                                                    <th class="text-center"> Customer Name </th>
                                                    <th class="text-center"> Actions </th>
                                                </thead>
                                                <tbody>
                                                    @foreach($deliver_receipt as $deliver_data)
                                                        <tr class="text-center">
                                                            <td> {{ $deliver_data -> DR_NO }}</td>
                                                            <td> {{ $deliver_data -> DR_DATE }}</td>
                                                            <td> {{ $deliver_data -> NAME }}</td>
                                                            <td><a type="button" class="btn btn-info" href=""><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <!-- /.row -->
        </section>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function(){

            $('.poNo').select2({
                placeholder: 'Select an option',
                dropdownAutoWidth: true,
            });

            $('#invoiceValidate').on('click', function(){
                var deliveryNo = $('#deliveryNo').val();
                var buttonVal = $('#invoiceValidate').val();

                $.ajax({
                    url: "/noValidate",
                    type: "POST",
                    data:{
                        '_token': $('input[name=_token]').val(),
                        'invoiceNo' : deliveryNo,
                        'buttonVal' : buttonVal
                    },
                    success: function(response){

                        if(response.status == "empty"){
                            $('#status').text("No Record Found");
                            $('#status').css("color", "red");
                            $('#status').css('font-size', '12px');
                            $('#issuedBy').val("");
                            $('#salesDetails').hide();
                            $('#submitButton').attr('disabled', true);
                        }else if(response.status == "DONE" || response.status == 'CANCELLED' || response.status == 'NO RECORD FOUND'){
                            $('#status').text(response.status);
                            $('#status').css("color", "red");
                            $('#status').css('font-size', '12px');
                            $('#issuedBy').val("");
                            $('#salesDetails').hide();
                            $('#submitButton').attr('disabled', true);
                        }else{
                            $('#status').text('Active');
                            $('#status').css("color", 'Green');
                            $('#status').css('font-size', '12px');
                            $('#issuedBy').val(response.issuedBy);
                            $('#issuedId').val(response.issuerID);
                            $('#salesDetails').show();
                            $('#submitButton').attr('disabled', false);
                        }
                    },
                    error: function(jqXHR){
                        console.log(jqXHR);
                    }
                });
            }); // Invoice Validation

            function submitButton(){

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('DeliverSales.store') }}" ,
                    type: "POST",
                    data: $('#deliverysalesinvoice').serialize(),
                    success: function(response){
                        try{
                            if(response.status == "success"){
                                swal('Delivery as Sales Invoice Successfully Inserted', '', 'success');
                            }else{
                                swal("Something has a error", "" , 'error');
                            }
                        }catch (Exception) {
                            swal(Exception , Exception , 'error');
                        }
                    },
                    error: function(jqXHR){
                        console.log(jqXHR);
                    }
                });
            }

            $('#submitButton').on('click', function(e){
                e.preventDefault();
                submitButton();
            });

        });
    </script>
@endsection