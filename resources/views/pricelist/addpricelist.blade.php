@extends('main')

@section('content')

    <style>

    </style>

    <div class="content-wrapper">

        <section class="content">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"> Add Customer Pricelist </h3>
                </div>
                <div class="box-body">


                    @foreach ($clientInfo as $row)

                    @endforeach

                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="CustomerName">Customer Name</label>
                            <input type="text" class="form-control" data-validation="required" id="custName" name="custName" placeholder="Customer Name" value="{{ $row -> NAME  }}" {{ $readonly }}>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="Address">Address</label>
                            <input type="text" class="form-control" data-validation="required" id="Address" name="Address" placeholder="Address" value="{{ $row -> ADDRESS }}" {{ $readonly }}>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="contPerson">Contact Person</label>
                            <input type="text" class="form-control" data-validation="required" id="contPerson" name="contPerson" placeholder="Contact Person" value="{{ $row -> CON_PERSON }}" {{ $readonly }}>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="Designation">Designation</label>
                            <input type="text" class="form-control" id="Designation" data-validation="required" name="Designation" placeholder="Designation" value="{{ $row -> DESIGNATION }}" {{ $readonly }}>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="telNumber">Telephone No.</label>
                            <input type="text" class="form-control" id="telNo" name="telNo" placeholder="Telephone NO." value="{{ $row -> TEL_NO }}" {{ $readonly }}>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="contNumber">Contact No.</label>
                            <input type="text" class="form-control" id="contNo" name="contNo" placeholder="Contact NO." value="{{ $row -> CELL_NO }}" {{ $readonly }}>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="emailAddress">Email Address</label>
                            <input type="text" class="form-control" id="emailAddress" data-validation="email" name="emailAddress" placeholder="Email Address" value="{{ $row -> EMAIL_ADDR }}" {{ $readonly }}>
                        </div>

                    </div>
                <form role="form" method="post" id="priceInfo">

                    <input type="hidden" value="{{ $clientID }}" name="clientID">
                    {{ csrf_field() }}

                    <div class="box">

                        <div class="box-header">
                            <h3 class="box-title"> Pricelist Information </h3>
                        </div>

                        <div class="row" id="template">
                            <div class="form-group col-md-3">
                                <label for="Products"> Products </label>
                                <select name="productCode" id="prodCode" data-validation="required" class="form-control">
                                    <option value="" selected> Choose Option</option>
                                    @foreach($product as $product)
                                        <option value="{{ $product -> PROD_CODE }}"> {{ $product -> PRODUCT  }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" id="prodName" name="prodName" value="">
                            </div>
                            <div class="form-group col-md-3 prodToBeClear">
                                <label for="Products"> Product Size </label>
                                <select name="prodSize" id="prodSize"  data-validation="required" class="form-control" disabled="true">
                                    <option value="" selected> Choose Option</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="Products"> Product Price </label>
                                <input type="text" id="prodPrice"data-validation="required"  name="prodPrice" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="PriceDate">Price Date</label>
                                <input type="date" class="form-control" data-validation="date" id="PriceDate" name="PriceDate" value="" >
                            </div>

                        </div>
                        <div class="box-footer">
                            <div class="btn-group pull-right">
                                <button type="button" id="submit" class="btn btn-primary ">Add Price</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary pull-left">Back</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" id="btnClear" class="btn btn-primary pull-left">Clear</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" id="btnMasterlist" class="btn btn-primary pull-left">Masterlist</button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>

            {{-- Table for Product Price --}}

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"> Saved Product Price </h3>
                </div>
                <div class="box-body">
                    <div class="row table-responsive col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th> Products </th>
                                    <th> Products Size </th>
                                    <th> Product Price </th>
                                    <th> Product Date </th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </section>

    </div>



@endsection


@section('scripts')

    <script type="text/javascript">




        $(document).ready(function(){


            $.validate({});

            $('#prodCode').on('change', function(){
                $('#prodName').val($('#prodCode option:selected').text());
                $.ajax({
                    url: "{{ route('getProductSize') }}?prodcode=" + $(this).val(),
                    method: 'GET',
                    success: function($data){
                        if($data == ''){
                            $('#prodSize option:selected').text("Choose Option");

                        }else{
                            $('#prodSize').html($data);
                            $('#prodSize').attr("disabled", false);
                        }
                    }
                });
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#submit').on('click', function(){

                $.validate({
                    form: '#priceInfo'
                });

                $.ajax({
                    url: '{{ route('PriceController.store') }}' ,
                    type: "POST",
                    data: $('#priceInfo').serialize(),
                    success: function( response ) {
                      if(response.status == "true"){
                                $("#priceInfo").trigger("reset");
                                $('#prodSize option:selected').text("Choose Option");
                                $('#prodSize').attr("disabled", true);
                                swal("Product Successfully Added", "", "success");
                      }else{
                          swal("Error in adding of Product", "danger");
                      }
                    }
                });
            });
        });


    </script>



@endsection