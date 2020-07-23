@extends('main')

@section('content')

    <style>
        .select2 {
            width:100%!important;
            height:100%!important;
        }
    </style>

    <div class="content-wrapper">
        <section class="content">
            <div class="box">
                <div class="box-header text-center">
                    <span> Delivery Receipt Information </span>
                </div>
                <form method="post" id="deliverform">
                    <div class="box-body">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="">DELIVERY NO. &nbsp;<label id="status"></label> </label>
                                <input type="text" class="form-control" id="deliveryNo" name="deliveryNo" value="0">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="lbl" for=""> &nbsp;</label>
                                <button type="button" class="form-control btn btn-primary btn-validate" id="invoiceValidate" value="DR"> Validate Delivery No. </button>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="lbl" for="">DELIVERY DATE</label>
                                <input type="date" id="cylinderDate" name="cylinderDate" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="lbl" for="">Customer</label>
                                <select id="customer" name="customer" class="form-control">
                                    <option value=""> Choose option </option>
                                    @foreach($data as $client_data)
                                        <option value="{{ $client_data -> CLIENTID }}"> {{ $client_data -> CLIENT_CODE }} - {{ $client_data -> NAME  }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for=""> PRODUCT </label>
                                <input type="text" id="product" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for=""> PRODUCT PRICE </label>
                                <input type="text" class="form-control" id="size">
                            </div>
                            <div class="form-group col-md-3">
                                <label for=""> PRODUCT QTY </label>
                                <input type="text" class="form-control" id="quantity">
                            </div>
                            <div class="form-group col-md-3">
                                <label for=""> Actions </label>
                                <button type="button" class="btn-info form-control" id="addProduct"> Add Product</button>
                            </div>
                        </div>
                        <div class="box-header text-center">
                            <span> Product List </span>
                        </div>

                        <div class="row table-responsive col-md-12">
                            <table id="prodListTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th class="text-center"> Product </th>
                                    <th class="text-center"> Products Price </th>
                                    <th class="text-center"> Product Qty </th>
                                    <th class="text-center"> Action </th>
                                </tr>
                                </thead>
                                <tbody id="productBody">

                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                            </div>
                            <div class="form-group col-md-4">
                            </div>
                            <div class="form-group col-md-4">
                                <label for=""> Total Amount: </label>
                                <input type="text" class="form-control" id="totalAmount" name="totalAmount" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for=""> Returned</label>
                                <input type="text" class="form-control" name="returned">
                            </div>
                            <div class="form-group col-md-4">
                                <label for=""> Received Date </label>
                                <input type="date" class="form-control" name="releasedDate">
                            </div>
                            <div class="form-group col-md-4">
                                <label for=""> Received By </label>
                                <input type="text" class="form-control" name="receivedBy">
                            </div>
                        </div>

                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="form-group col-md-3 pull-left">
                                <button type="button" id="cancelInvoice" class="form-control btn btn-primary"> Cancel Invoice </button>
                            </div>
                            <div class="form-group col-md-3 pull-right">
                                <button type="button" id="submitButton" class="form-control btn btn-primary"> Add Cylinder Receipt </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('BladeJavascript/SalesRecord/AddDelivery.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            $('#size').maskMoney();

           function validationonFail(){

           }

            function submitButton(){


                var deliveryNo = $('#deliveryNo').val();
                var cylinderDate = $('#cylinderDate').val();

                if(deliveryNo == "0" ){
                    swal("Please input required fields", "With red line", "error");
                    $('#deliveryNo').css("border", "1px solid red");
                }if(cylinderDate == ""){
                    swal("Please input required fields", "With red line", "error");
                    $('#cylinderDate').css("border", "1px solid red");
                }if(deliveryNo != "0" && cylinderDate != ""){
                    $('#deliveryNo').css("border", "");
                    $('#cylinderDate').css("border", "");
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{ route('Deliver.store') }}",
                        type: "POST",
                        data: $('#deliverform').serialize(),
                        success: function (response) {
                            try {
                                if (response.status == "success") {
                                    swal('Delivery Receipt successfully added', '', 'success');
                                    window.history.back();
                                }

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