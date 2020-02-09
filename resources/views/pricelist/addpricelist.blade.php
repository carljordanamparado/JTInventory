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
                <form role="form" method="post" action="">
                    {{ csrf_field() }}

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
                        <div class="form-group col-md-3">
                            <label for="telNumber">Telephone No.</label>
                            <input type="text" class="form-control" id="telNo" name="telNo" placeholder="Telephone NO." value="{{ $row -> TEL_NO }}" {{ $readonly }}>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="contNumber">Contact No.</label>
                            <input type="text" class="form-control" id="contNo" name="contNo" placeholder="Contact NO." value="{{ $row -> CELL_NO }}" {{ $readonly }}>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="emailAddress">Email Address</label>
                            <input type="text" class="form-control" id="emailAddress" data-validation="email" name="emailAddress" placeholder="Email Address" value="{{ $row -> EMAIL_ADDR }}" {{ $readonly }}>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="PriceDate">Price Date</label>
                            <input type="date" class="form-control" data-validation="date" id="PriceDate" name="PriceDate" value="" >
                        </div>
                    </div>

                    <div class="box">

                        <div class="box-header">
                            <h3 class="box-title"> Pricelist Information </h3>
                        </div>
                            <div class="box-body table-responsivebody">
                                    <table class="table table-bordered table-hover table-sortable" id="tab_logic">
                                        <thead>
                                            <tr >
                                                <th class="text-center">
                                                    <label for="Products"> Products </label>
                                                </th>
                                                <th class="text-center">
                                                    <label for="Products"> Product Size </label>
                                                </th>
                                                <th class="text-center">
                                                    <label for="Products"> Product Price </label>
                                                </th>
                                                <th class="text-center" style="border-top: 1px solid #ffffff; border-right: 1px solid #ffffff;">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="temp_body">

                                            <tr id="temp0">
                                                <td data-name="prodCode">
                                                    <select name="productCode" id="prodCode" class="form-control prodCode">
                                                        <option value="" selected> Choose Option</option>
                                                        @foreach($product as $product2)
                                                            <option value="{{ $product2 -> PROD_CODE }}"> {{ $product2 -> PRODUCT  }}</option>
                                                        @endforeach
                                                    </select>

                                                </td>
                                                <td data-name="prodSize">
                                                    <select name="prodSize" id="prodSize" class="form-control prodSize">
                                                        <option value="" selected> Choose Option</option>
                                                        @foreach($prodSize as $prodSize2)
                                                            <option value="{{ $prodSize2 -> SIZES }}"> {{ $prodSize2 -> SIZES  }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td data-name="prodPrice">
                                                    <input type="text" id="prodPrice" name="prodPrice" class="form-control prodPrice">
                                                </td>
                                            </tr>
                                            <tr id="temp1"></tr>

                                        </tbody>
                                    </table>

                                </div>
                            <div class="box-footer">
                                    <a id="add_row" class="btn btn-primary pull-right">Add Product</a>
                                    <a id='delete_row' class="pull-right btn btn-warning">Delete Product</a>
                                
                            </div>
                        </div>

                        <div class="box">
                            <div class="box-header">

                            </div>
                            <div class="box-body">
                                <button type="submit" class="btn btn-success"> Add Pricelist Information </button>
                            </div>
                        </div>
                </form>

                </div>
            </div>
        </section>

    </div>



@endsection


@section('scripts')
    <script type="text/javascript">

        $(document).ready(function(){

            var i = 1;



            $('.prodPrice').maskMoney();


            {{--for(var j = 0 ; i < j ; j++){--}}

            {{--    $('#prodCode'+j).on('change', function(){--}}

            {{--        alert("hello");--}}

            {{--        --}}{{--$('#prodName'+i).val($('#prodCode+i+ option:selected').text());--}}
            {{--        --}}{{--$.ajax({--}}
            {{--        --}}{{--    url: "{{ route('getProductSize') }}?prodcode=" + $(this).val(),--}}
            {{--        --}}{{--    method: 'GET',--}}
            {{--        --}}{{--    success: function($data){--}}
            {{--        --}}{{--        if($data == ''){--}}
            {{--        --}}{{--            $('#prodSize+i+ option:selected').text("Choose Option");--}}
            {{--        --}}{{--        }else{--}}
            {{--        --}}{{--            $('#prodSize'+i).html($data);--}}
            {{--        --}}{{--        }--}}
            {{--        --}}{{--    }--}}
            {{--        --}}{{--});--}}
            {{--    });--}}

            {{--}--}}

            $('#add_row').on('click', function(){

                var prodSelect = "<td><select name='productCode' id='prodCode' class='form-control prodCode'><option value='' selected> Choose Option</option>@foreach($product as $product)<option value='{{ $product -> PROD_CODE }}'> {{ $product -> PRODUCT  }} </option>@endforeach</select> <input type=\"hidden\" id=\"prodName\" value=\"\"></td>";

                var prodSize = "<td> <select name=\"prodSize\" id=\"prodSize\" class=\"form-control prodSize\">\n" +
                    "                                                        <option value=\"\" selected> Choose Option</option>\n" +
                    "                                                        @foreach($prodSize as $prodSize)\n" +
                    "                                                            <option value=\"{{ $prodSize -> SIZES }}\"> {{ $prodSize -> SIZES  }}</option>\n" +
                    "                                                        @endforeach\n" +
                    "                                                    </select></td>";
                var prodPrize = "<td><input type=\"text\" id=\"prodPrice"+i+"\" name=\"prodPrice\" class=\"form-control prodPrice\"><td>";

                $('#temp'+i).html(prodSelect + prodSize + prodPrize);
                $('#tab_logic').append('<tr id="temp'+(i+1)+'"></tr>');
                $('#prodPrice'+i).maskMoney();
                i++;

            });

            $("#delete_row").click(function(){
                if(i>1){
                    $("#temp"+(i-1)).html('');
                    i--;
                }
            });





        });

    </script>
@endsection