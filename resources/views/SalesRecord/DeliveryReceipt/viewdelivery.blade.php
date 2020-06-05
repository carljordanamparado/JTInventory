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
                                            <button type="button" class="btn btn-primary col-md-12" data-toggle="modal" data-target=".bd-example-modal-lg"> Add Delivery As Sales Invoice </button>
                                            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post" id="deliverysalesinvoice">
                                                                {{ csrf_field() }}
                                                                <div class="row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="">DELIVERY NO. &nbsp;<label id="status"></label> </label>
                                                                        <input type="text" class="form-control" id="deliveryNo" name="deliveryNo" value="0">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="lbl" for=""> &nbsp;</label>
                                                                        <button type="button" class="form-control btn btn-primary btn-validate" id="invoiceValidate" value="DR"> Validate Delivery No. </button>
                                                                    </div>

                                                                </div>
                                                                <div class="row">
                                                                    <div class="form-group col-md-6">
                                                                        <label class="lbl" for="">DELIVERY DATE</label>
                                                                        <input type="date" id="invoiceDate" name="invoiceDate" class="form-control">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label class="lbl" for="">SALES INVOICE NO.</label>
                                                                        <select id="salesInvoice" class="form-control poNo" name="poNo">
                                                                            <option value="" custId="">Choose Option</option>
                                                                            @foreach($data as $data)
                                                                                <option value="{{ $data->INVOICE_NO }}"> {{ $data -> INVOICE_NO }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" class="close" data-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary" id="submitButton">Save changes</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-body table-responsive">
                                            <table id="deliveryInvoice" class="table table-bordered table-striped">
                                                <thead>
                                                    <th class="text-center">Delivery No.</th>
                                                    <th class="text-center">Delivery Sales Invoice</th>
                                                    <th class="text-center">Deliver Date</th>

                                                </thead>
                                                <tbody>
                                                        @foreach($deliver as $data)
                                                            <tr class="text-center">
                                                                <td> {{ $data -> DR_NO }}</td>
                                                                <td> {{ $data -> INVOICE_NO }}</td>
                                                                <td> {{ $data ->  RECEIPT_DATE }}</td>
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
                                                    <th class="text-center"> Actions </th>\
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