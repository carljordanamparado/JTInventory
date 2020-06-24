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
                                <button type="button" id="back" class="btn btn-primary pull-left">Back</button>
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
                        <table id="prodListTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center"> Products </th>
                                    <th class="text-center"> Products Size </th>
                                    <th class="text-center"> Product Price </th>
                                    <th class="text-center"> Product Date </th>
                                    <th class="text-center"> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prodList as $prodList)
                                    <tr>

                                        <td class="text-center"><input type="hidden" id="prodID" value="{{ $prodList-> ID }}">{{ $prodList-> PRODUCT }}</td>
                                        <td class="text-center">{{ $prodList-> SIZE }}</td>
                                        <td class="text-center"><input type="text" name="editProdPrice" class="prodPrice" value="{{ number_format($prodList-> PRODUCT_PRICE, 2) }}" data-value="{{ number_format($prodList-> PRODUCT_PRICE, 2) }}" disabled="true"></td>
                                        <td class="text-center">{{ $prodList-> PRICE_DATE }}</td>
                                        <td class="text-center">

                                            <div class="btn-group-vertical btn-action">
                                                <a type="button" class="btn btn-info btn-edit"><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                                                <a type="button" class="btn btn-warning"><span class="fa fa-trash">&nbsp;&nbsp;</span>Delete</a>
                                            </div>

                                            <div class="btn-group-vertical btn-edit-yes hidden">
                                                <a type="button" class="btn btn-info btn-yes"><span class="fa fa-pencil">&nbsp;&nbsp;</span>Yes</a>
                                                <a type="button" class="btn btn-danger btn-no"><span class="fa fa-trash">&nbsp;&nbsp;</span>No</a>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach
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
            // Validation
            $.validate({});
            // End of Validation

            // Datatables
            $('#prodListTable').DataTable({
                "columnsDefs":[
                    { "orderDataType" : "dom-text", type: 'numeric-comma' , },
                ]
            });
            // End of Datatables

            // Dynamic Select Option of Product => Size
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
            // End of file

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Submittion of Products
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
                                swal({title: "Success!", text: "Product Price is added.", type: "success"})
                                    .then((value) => {
                                        location.reload();
                                    });

                      }else{
                          swal("Error in adding of Product", "danger");
                      }
                    }
                });
            });
            // End of file

            p

        });

    </script>



@endsection