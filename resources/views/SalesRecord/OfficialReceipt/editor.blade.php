@extends('main')

@section('content')

    <style>

    </style>


    <div class="content-wrapper">
        <section class="content">
            <div class="box">
                <div class="box-header text-center">
                    <span> Official Receipt </span>
                </div>
                <div class="box-body">
                    <form method="post" id="orForm">
                        {{ csrf_field() }}
                        <div class="row">
                            @foreach($or as $or)
                            @endforeach
                            <input type="hidden" name="id" value="{{$or->ID}}">
                            <div class="form-group col-md-3">
                                <label for="">OR NO. &nbsp;<label id="status"></label> </label>
                                <input type="text" class="form-control" id="orNo" name="orNo" value="{{ $or -> OR_NO }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="lbl" for=""> &nbsp;</label>
                                <button type="button" class="form-control btn btn-primary btn-validate" id="invoiceValidate" value="OR"> Validate Delivery No. </button>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="lbl" for="">OR DATE</label>
                                <input type="date" id="cylinderDate" name="cylinderDate" class="form-control" value="{{ $or->OR_DATE }}">
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="lbl" for="">Customer</label>
                                <select id="customer" name="customer" class="form-control">
                                    <option value=""> Choose option </option>
                                    @foreach($data as $client_data)
                                        <option value="{{ $client_data -> CLIENTID }}" {{ ( $client_data->CLIENTID == $or -> CLIENT_ID) ? 'selected' : '' }}> {{ $client_data -> CLIENT_CODE }} - {{ $client_data -> NAME  }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 radio-label-vertical-wrapper">
                                <label for = "name">PAY TYPE</label>
                                <div>
                                    <label class = "checkbox-inline">
                                        <input type = "radio" id="inlineCheckbox1" name="radioType" value="0" {{  $or -> PAYMENT_TYPE == 0 ? 'checked' : '' }}> ACCOUNT
                                    </label>
                                    <label class = "checkbox-inline">
                                        <input type = "radio" id="inlineCheckbox2" name="radioType" value="1" {{  $or -> PAYMENT_TYPE == 1 ? 'checked' : '' }}> C.O.D.
                                    </label>
                                    <label class = "checkbox-inline">
                                        <input type = "radio" id="inlineCheckbox2" name="radioType" value="2 {{  $or -> PAYMENT_TYPE == 2 ? 'checked' : '' }}"> DEPOSIT
                                    </label>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <table id="prodListTable" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th class="text-center">  </th>
                                        <th class="text-center"> Invoice No </th>
                                        <th class="text-center"> Invoice Date </th>
                                        <th class="text-center"> Amount </th>
                                    </tr>
                                    </thead>
                                    <tbody id="">
                                        @foreach($or_list as $data_list)
                                            <tr class="text-center">
                                                <td></td>
                                                <td>{{ $data_list -> INVOICE_NO }}</td>
                                                <td>{{ $data_list -> INVOICE_DATE }}</td>
                                                <td>{{ $data_list -> AMOUNT }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row hidden">
                            <div class="form-group col-md-3">
                                <label class="lbl" for="">P/O Payment OR No.</label>
                                <input type="text" id="PaymentOr" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="lbl" for="">P/O Payment OR No.</label>
                                <button type="button" class="form-control btn btn-primary btn-validate" id="loadPayment"> Load P/O Payment </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="">Payment Type</label>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="p1" name="PaymentType" value="1"  class="custom-control-input paymentType" {{  $or -> PAY_MODE == 1 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="customRadioInline1" >Partial Payment</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="p2" name="PaymentType" value="2" class="custom-control-input paymentType" {{  $or -> PAY_MODE == 2 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="customRadioInline2">Over Payment</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="p3" name="PaymentType" value="0" class="custom-control-input paymentType" {{  $or -> PAY_MODE == 0 ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="customRadioInline2">Not Applicable</label>
                                </div>
                            </div>
                            {{--<div class="form-group col-md-3">
                                <label class="lbl" for="">Invoice No.</label>
                                <input type="text" id="InvoiceNo" class="form-control" readonly>
                            </div>--}}
                            <div class="form-group col-md-3">
                                <label class="lbl" for="">Amount Paid</label>
                                <input type="text" id="amountPaid" class="form-control" name="amountPaid">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="lbl" id="labelId" for="">Remaining Balance</label>
                                <input type="text" id="remBalance" name="remBalance" class="form-control" readonly>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                            </div>
                            <div class="form-group col-md-3">
                                <input type = "checkbox" id="credCheck">
                                <label class="lbl" for="">1% Creditable</label>
                                <input type="text" id="creditable" name="creditable" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="lbl" for="">Net Sales</label>
                                <input type="text" id="netSales" name="netSales" class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="lbl" for="">Gross Sales</label>
                                <input type="text" id="grossSales" name="grossSales" class="form-control" value="{{ number_format($or -> TOTAL,2) }}" readonly>
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                            </div>
                            <div class="form-group col-md-3">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="lbl" for="">Double Payment Invoice No.</label>
                                <input type="text" id="doublePaymentNo" class="form-control" name="doublePaymentNo">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="lbl" for="">Double Payment Amount</label>
                                <input type="text" id="doublePaymentAmt" name="doublePaymentAmt" class="form-control">
                            </div>

                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label class="lbl" for="">Sales Representative</label>
                                <input type="text" class="form-control" id="issuedBy" name="issuedBy" value="{{ $or -> SALESREP_NAME }}" readonly>
                                <input type="text" class="form-control hidden" id="issuedId" name="issuedId" readonly >
                            </div>
                            <div class="form-group col-md-3 radio-label-vertical-wrapper">
                                <label for = "name"></label>
                                <div>
                                    <label class = "checkbox-inline">
                                        <input type = "radio" class="payType"  name="cashType" value="1" {{  $or -> PAYMENT_TYPE == 1 ? 'checked' : '' }}> Cheque
                                    </label>
                                    <label class = "checkbox-inline">
                                        <input type = "radio" class="payType" name="cashType" value="0" {{  $or -> PAYMENT_TYPE == 0 ? 'checked' : '' }}> Cash
                                    </label>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="lbl" for="">Remarks</label>
                                <input type="text" id="Remarks" name="Remarks" class="form-control" value="{{ $or ->REMARKS }}">
                            </div>

                        </div>
                        <div class="row" id="checkDetails">
                            <div class="form-group col-md-4">
                                <label class="lbl" for="">Check Date</label>
                                <input type="date" class="form-control cheque" id="checkDate" name="checkDate" value="{{ $or->CHECK_DATE }}" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="lbl" for="">Check No.</label>
                                <input type="text" id="Checkno" name="Checkno" class="form-control cheque" readonly value="{{ $or->CHECK_NO }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="lbl" for="">Bank</label>
                                <input type="text" id="Bank" name="Bank" class="form-control cheque" readonly value="{{ $or -> BANK }} ">
                            </div>

                        </div>

                        <div class="box-footer">
                            <div class="row">
                                <div class="form-group col-md-3 pull-left">
                                    <button type="button" id="cancelInvoice" class="form-control btn btn-primary"> Cancel Invoice </button>
                                </div>
                                <div class="form-group col-md-3 pull-right">
                                    <button type="button" id="submitButton" class="form-control btn btn-primary"> Edit Official Receipt </button>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
            <!-- /.row -->
        </section>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('BladeJavascript/SalesRecord/addOR.js') }}"></script>
    <script>
        $(document).ready(function(){

            $('#prodListTable').dataTable({
                scrollY:        '30vh',
                scrollCollapse: true,
                paging:         false,
                searching: false
            });

            function submitButton(){

                var deliveryNo = $('#orNo').val();
                var cylinderDate = $('#cylinderDate').val();

                if(deliveryNo == "0" ){
                    swal("Please input required fields", "With red line", "error");
                    $('#invoiceNo').css("border", "1px solid red");
                }if(cylinderDate == ""){
                    swal("Please input required fields", "With red line", "error");
                    $('#invoiceDate').css("border", "1px solid red");
                }if(deliveryNo != "0" && cylinderDate != "") {
                    $('#invoiceNo').css("border", "");
                    $('#invoiceDate').css("border", "");

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{ route('updateOR') }}",
                        type: "POST",
                        data: $('#orForm').serialize(),
                        success: function (response) {
                            try {
                                swal('Official Receipt successfully edited', '', 'success');
                               location.reload();
                            } catch (Exception) {
                                swal(Exception, Exception, 'error');
                            }
                        },
                        error: function (jqXHR) {
                            console.log(jqXHR);
                        }
                    });

                }
            }

            $('#submitButton').on('click', function(e){
                e.preventDefault();
                submitButton();
            });
        });
    </script>
@endsection