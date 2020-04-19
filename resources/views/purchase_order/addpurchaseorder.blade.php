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
            <form role="form" method="post" action="{{ route('PurchaseOrderController.store') }}">
                {{ csrf_field() }}
            <div class="box">
                <div class="box-header">
                  <small> Purchase Order Information </small>
                    <input type="hidden" name="status" value="1">
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Customer Client</label>
                            <select class="form-control" id="custCode" name="custCode">
                              <option selected="selected">Choose Option</option>
                              @foreach($client as $row)
                                  <option value="{{ $row -> CLIENTID }}"> {{ $row -> CLIENT_CODE  }} - {{ $row -> NAME }} </option>
                              @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Purchase NO.</label>
                            <input class="form-control" type="text" name="poNo" id="poNo">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Purchase Date</label>
                            <input class="form-control" type="date" name="poDate" id="poDate">
                        </div>
                    </div>
                    {{--End of line--}}
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label>Product</label>
                            <select class="form-control" id="productCode" >
                                <option selected="selected">Choose Option</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Product Size</label>
                            <select class="form-control" id="productSize" >
                                <option selected="selected">Choose Option</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Product Qty</label>
                            <input class="form-control" type="text"  id="productQty" value="0">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="emailAddress">Add Balance</label>
                            <button class="form-control btn btn-info" id="addProduct" type="button"> Add Product </button>
                        </div>
                    </div>
                </div>
            </div>

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
                                <th class="text-center"> Product Qty </th>
                                <th class="text-center"> Action </th>
                            </tr>
                            </thead>
                            <tbody class="poTable">

                            </tbody>
                        </table>

                    </div>
                </div>
                <div class="box-footer">
                    <div class="form-group col-md-3 pull-right">
                        <button class="form-control btn btn-info" type="submit"> Add Purchase Order </button>
                    </div>
                </div>



            </div>
            </form>
            <!-- /.row -->
        </section>

    </div>


@endsection

@section('scripts')

    <script type="text/javascript">
        $('#custCode').select2({
            selectOnClose: true,
        });

             function product(){
                 $.ajax({
                     url: "{{ route('getProductPO') }}?prodcode=" + $('#custCode').val(),
                     method: 'GET',
                     success: function($data){
                         console.log($data);
                         if($data.html == ''){
                             $('#productCode option:selected').text("Choose Option");
                         }else{
                             $('#productCode').append($data.html);
                             $('#productCode').attr("disabled", false);
                         }
                     }
                 });
             }

            function productSize(){

                var id = $('#custCode').val();
                var prodcode = $('#productCode').val();

                $.ajax({
                    url: "{{ route('getProductSizePO') }}",
                    method: 'GET',
                    data:
                        {   'id': id,
                            'prodcode' : prodcode
                        },
                    success: function($data){
                        console.log($data);
                        if($data.html == ''){
                            $('#productSize option:selected').text("Choose Option");

                        }else{
                            $('#productSize').append($data.html);
                            $('#productSize').attr("disabled", false);
                        }
                    }
                });
            }



        $('#custCode').on('change', function(){

                $('.poTable').empty();

                product();
        });



        $('#productCode').on('change', function(){
             if($(this).val() == "Choose Option"){
                 $('#productSize').empty();
                 $('#productSize').append("<option value='' selected> Choose Option  </option>")
             }else{
                 $('#productSize').empty();
                 productSize();
             }
        });

        $('#addProduct').on('click', function(){

            var productName = $('#productCode option:selected').text();
            var productCode = $('#productCode option:selected').val();
            var productSize = $('#productSize option:selected').text();
            var productQty = $('#productQty').val();

            var flag = '';

            $(".poTable").find("tr").each(function () {
                var td1 = $(this).find("td:eq(0)").text();

                console.log(td1);

                if ((productName == td1)) {
                    flag = 1;
                }
            });

            if(flag == 1){
                swal("Exisiting Product" , "" , "error");
            }else{
                var tableElements = "<tr class='text-center'> " +
                    "<td><input type='hidden' name='productCode[]' id='productCode' value='"+ productCode + "'>" + productName + "</td> " +
                    "<td><input type='hidden' name='productSize[]' id='productSize' value='"+ productSize + "'>"+ productSize +"</td> " +
                    "<td><input type='hidden' name='productQty[]' id='productQty' value='"+ productQty + "'>"+ productQty +"</td> " +
                    "<td><button class='btn btn-error' type='button' id='btn-remove'> Remove </button></td>" +
                    " </tr>";

                $('.poTable').append(tableElements);
            }
        });

        $(document).on('click', '#btn-remove', function(){
            $(this).closest('tr').remove();
        });

    </script>

@endsection