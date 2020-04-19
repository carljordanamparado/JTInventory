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
  </style>

  <div class="content-wrapper">

      @include('purchase_order.otherproduct')

   <section class="content">
       <div class="box">
          <div class="box-header text-center">
            <span> Sales Invoice Information </span>
          </div>
           <form method="post" action="{{ route('Sales.store') }}">
               <div class="box-body">
                   {{ csrf_field() }}
                   <div class="row">
                       <div class="form-group col-md-4">
                         <label for="">INVOICE NO.<label id="status"></label> </label>
                         <input type="text" class="form-control" id="invoiceNo" name="invoiceNo" value="0">
                       </div>
                       <div class="form-group col-md-4">
                        <label class="lbl" for=""> &nbsp;</label>
                        <button type="button" class="form-control btn btn-primary btn-validate" id="invoiceValidate" value="invoice"> Validate Invoice </button>
                      </div>
                      <div class="form-group col-md-4">
                           <label class="lbl" for="">INVOICE DATE</label>
                           <input type="date" id="invoiceDate" name="invoiceDate" class="form-control">
                      </div>
                   </div>
                   <div id="salesDetails">

                   <div class="row">
                       <div class="form-group col-md-4">
                           <label for=""> P.O. NO. </label>
                            <select id="poNo" class="form-control" name="poNo">
                                <option value="" custId="">Choose Option</option>
                                        @foreach($poNo as $po)
                                        <option value="{{ $po->PO_NO }}" custId="{{ $po->CLIENTID }}">{{ $po->PO_NO }}</option>
                                    @endforeach
                            </select>
                       </div>
                       <div class="form-group col-md-4">
                           <label for=""> CUSTOMER DETAILS </label>
                           <select id="CustDetails" name="custDetails" class="form-control hidden">

                           </select>
                           <input type="text" id="custName" class="form-control" readonly>
                       </div>
                       <div class="form-group col-md-4">
                           <label for=""> PO DATE </label>
                           <input type="date" id="poDate" name="poDate" class="form-control" readonly>
                       </div>
                   </div>

                   </div>
                   <div class="product col-md-12">
                       <div class="row">
                           <div class="box-header text-center">
                               <span> Product Information </span>
                           </div>
                           <div class="form-group col-md-2">
                               <label for="">PRODUCTS</label>
                               <select id="productItem" class="form-control">
                                   <option value=""> Choose Option </option>
                               </select>
                           </div>
                           <div class="form-group col-md-2">
                               <label for="">SIZE</label>
                               <input type="text" id="productSize" class="form-control" readonly>
                           </div>
                           <div class="form-group col-md-2">
                               <label for="">Quantity</label>
                               <input type="text" id="productQuantity" class="form-control" readonly>
                           </div>
                           <div class="form-group col-md-2">
                               <label for="">Amount</label>
                               <input type="text" id="productAmount" class="form-control" readonly>
                           </div>
                           <div class="form-group col-md-2">
                               <label for=""> &nbsp;</label>
                               <button type="button" class="btn-info form-control" id="addProduct"> Add Product</button>
                           </div>
                           <div class="form-group col-md-2">
                               <label for=""> &nbsp;</label>

                               <button type="button" class="btn-success form-control" id="otherCharges" data-toggle="modal" data-target="#otherModal"> Others Charges</button>
                           </div>

                       </div>
                       <div class="box-header text-center">
                           <span> Product List  </span>
                           <hr class="solid">
                       </div>
                       <div class="row table-responsive col-md-12">
                           <table id="prodListTable" class="table table-bordered table-striped">
                               <thead>
                               <tr>
                                   <th class="text-center"> Product </th>
                                   <th class="text-center"> Products Size </th>
                                   <th class="text-center"> Product Price </th>
                                   <th class="text-center"> Product Qty </th>
                                   <th class="text-center"> Action </th>
                               </tr>
                               </thead>
                               <tbody id="productBody">

                               </tbody>

                           </table>
                       </div>


                       <div class="row table-responsive col-md-12">
                           <div class="box-header text-center">
                               <span> Other Charges Information </span>
                               <hr class="dotted">
                           </div>
                           <table id="otherTable" class="table table-bordered table-striped">
                               <thead>
                               <tr>
                                   <th class="text-center"> Particulars </th>
                                   <th class="text-center"> Particular Price </th>
                                   <th class="text-center"> Particular Qty </th>
                                   <th class="text-center"> Action </th>
                               </tr>
                               </thead>
                               <tbody id="otherBody">

                               </tbody>

                           </table>
                       </div>
                         <div class="row">
                             <div class="form-group col-md-2">
                               <label for="">Deposit</label>
                               <label class="checkbox-inline">
                                <input type="checkbox" value="" id="depCheckbox" style="text-align: center;display: block;">
                                <input type="text" value="0" class="form-control payment" name="depositAmt" id="depositAmt" style="" readonly>
                               </label>
                           </div>
                           <div class="form-group col-md-2">
                               <label for="">Downpayment</label>
                               <input type="text" value="0" class="form-control " name="downPay" id="downPay" value="0">
                           </div>
                           <div class="form-group col-md-2">
                                 <label for="">Other Charges</label>
                                 <input type="text" value="0" class="form-control payment" name="otherCharge" id="otherCharge" style="" readonly>
                           </div>
                             <div class="form-group col-md-2">
                                 <label for="">Grand Total</label>
                                 <input type="text" value="0" class="form-control" name="grandTotal" id="grandTotal" style="" readonly>
                             </div>
                           <div class="form-group col-md-2">
                               <label for="">Balance</label>
                                    <input type="text" value="0" class="form-control" name="balAmount" id="balAmount" style="" readonly>
                           </div>
                             <div class="form-group col-md-2">
                                 <label for="">Payment Type</label>
                                 <div class="custom-control custom-radio custom-control-inline">
                                     <input type="radio" id="customRadioInline1" name="PaymentType" value="1"  class="custom-control-input">
                                     <label class="custom-control-label" for="customRadioInline1" checked>Cash</label>
                                 </div>
                                 <div class="custom-control custom-radio custom-control-inline">
                                     <input type="radio" id="customRadioInline2" name="PaymentType" value="2" class="custom-control-input">
                                     <label class="custom-control-label" for="customRadioInline2">Accounts</label>
                                 </div>
                             </div>
                       </div>
                   </div>
               </div>

               <div class="box-footer">
                   <div class="row">
                       <div class="form-group col-md-4 pull-right">
                           <button type="submit" id="submitButton" class="form-control btn btn-primary"> Add Users </button>
                       </div>
                   </div>
               </div>
               </form>

       </div>

       <!-- /.row -->
     </section>

</div>

@endsection


@section('scripts')

<script type="text/javascript">

    $(document).ready(function(){

        // $('#salesDetails').hide();
        $('#unitPrice').maskMoney();

        function clearForm(){
            $('#particular').val("");
            $('#unitPrice').val("");
            $('#Quantity').val("");
            $('#otherCharge').val(0);
        }

        function addParticular(){
            var particular = $('#particular').val();
            // var unitPrice = parseFloat($('#unitPrice').val().replace(/,/g, '')); // Remove Comma in Parse Float Value
            var unitPrice = $('#unitPrice').val();
            var qty = parseFloat($('#Quantity').val());

            if(particular == "" || unitPrice == "" || qty == ""){

            }else{

            var tableElements = "<tr class='text-center'> " +
                "<td><input type='hidden' name='particular[]' id='particular' value='" + particular + "'>" + particular + "</td> " +
                "<td id='tdPrice'><input type='hidden' name='unitPrice[]' id='unitPrice' value='" + unitPrice + "'>" + unitPrice + "</td> " +
                "<td id='tdQty'><input type='hidden' name='qty[]' id='qty' value='" + qty + "'>" + qty + "</td> " +
                "<td><button class='btn btn-error' type='button' id='btn-remove-particular'> Remove </button></td>" +
                " </tr>";
            }

            $('#otherBody').append(tableElements);
        }

        function totalOtherCharges(){

            var totalAmount = '';
            var totalQty = '';

            $("#otherBody tr td:nth-child(2)").each(function () {
                var data = parseFloat($(this).text().replace(/,/g, ''));
                totalAmount = parseFloat(totalAmount + data);
            });

            $("#otherBody tr td:nth-child(3)").each(function () {
                var data = parseFloat($(this).text().replace(/,/g, ''));
                totalQty = parseFloat(totalQty + data);
            });

            var totalCharges = totalQty * totalAmount;

            $('#otherCharge').val(totalCharges.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        }

        function totalProductAmount(){

            var totalAmount = '';
            var totalQty = '';

            $("#productBody tr td:nth-child(3)").each(function () {
                var data = parseFloat($(this).text().replace(/,/g, ''));
                totalAmount = parseFloat(totalAmount + data);
            });

            $("#productBody tr td:nth-child(4)").each(function () {
                var data = parseFloat($(this).text().replace(/,/g, ''));
                totalQty = parseFloat(totalQty + data);
            });

            var otherCharges = parseFloat($('#otherCharge').val().replace(/,/g, ''));

            var totalCharges = (totalQty * totalAmount) + otherCharges ;

            $('#grandTotal').val(totalCharges.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            $('#balAmount').val(totalCharges.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        }


        $('#addParticular').on('click', function(){
            addParticular();
            clearForm();
            totalOtherCharges();
            totalProductAmount();
        });

        $(document).on('click', '#btn-remove-particular', function(){
            $(this).closest('tr').remove();
            totalOtherCharges();
            totalProductAmount();
        });

        $('#invoiceValidate').on('click', function(){
            var invoiceNo = $('#invoiceNo').val();
            var buttonVal = $('#invoiceValidate').val();

            $.ajax({
                url: "/noValidate",
                type: "POST",
                data:{
                    '_token': $('input[name=_token]').val(),
                    'invoiceNo' : invoiceNo,
                    'buttonVal' : buttonVal
                },
                success: function(response){

                    if(response.status == "empty"){
                        $('#status').text("No Sales Invoice");
                        $('#status').css("color", "red");
                        $('#status').css('font-size', '12px');
                        $('#salesDetails').hide();
                        $('#submitButton').attr('disabled', true);
                    }else if(response.status == "DONE" || response.status == 'CANCELLED' || response.status == 'NO RECORD FOUND'){
                        $('#status').text(response.status);
                        $('#status').css("color", "red");
                        $('#status').css('font-size', '12px');
                        $('#salesDetails').hide();
                        $('#submitButton').attr('disabled', true);
                    }else if(response.status == 'notEmpty'){
                        $('#status').text('Active');
                        $('#status').css("color", 'Green');
                        $('#status').css('font-size', '12px');
                        $('#salesDetails').show();
                        $('#submitButton').attr('disabled', false);
                    }
                },
                error: function(jqXHR){
                    console.log(jqXHR);
                }
            });
        }); // Invoice Validation

        function clearProductInfo(){
            $('#productSize').val("");
            $('#productQuantity').val("");
            $('#productAmount').text("");
            $('#productAmount').val("");
        }

        function customerDetailsAndDate(){
            var cust_id = $('#poNo option:selected').attr("custId");
            var po_id = $('#poNo option:selected').text();
            $.ajax({
                url: "/poCustomerDetails",
                type: "POST",
                data:{
                    '_token': $('input[name=_token]').val(),
                    'cust_id' : cust_id,
                    'po_id' : po_id
                },
                success: function(response){
                    $('#CustDetails option').remove();
                    $('#CustDetails').append(response.html);
                    $('#CustDetails').attr("readonly", true);
                    $('#CustDetails').hide();
                    $('#custName').val(response.html2);
                    $('#poDate').val(response.date);
                    $('#productItem').empty().append("<option value=''> Choose Option </option> ");
                    $('#productItem').append(response.product);

                },
                error: function(jqXHR){
                    console.log(jqXHR);
                }
            });
        }

        function productDetails(){
            var prodCode = $('#productItem option:selected').val();
            var po_id = $('#poNo option:selected').text();
            var cust_id = $('#poNo option:selected').attr("custId");
            $.ajax({
                url: "/poProductDetails",
                type: "POST",
                data:{
                    '_token': $('input[name=_token]').val(),
                    'prodCode' : prodCode,
                    'po_id' : po_id,
                    'cust_id' : cust_id
                },
                success: function(response){
                    $('#productSize').val(response.size);
                    $('#productQuantity').val(response.quantity);
                    var amount = (response.amount);
                    $('#productAmount').val(amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                },
                error: function(jqXHR){
                    console.log(jqXHR);
                }
            });
        }

        $('#poNo').on('change', function(){
            customerDetailsAndDate();
            clearProductInfo();
            clearForm();
            $('#productBody').empty();
        });

        $('#productItem').on('change', function(){
            if($('#productItem option:selected').val() == ""){
                clearProductInfo();
            }else{
                productDetails();
            }

        });

        function addProductList(){

            var productName = $('#productItem option:selected').text();
            var productCode = $('#productItem option:selected').val();
            var productSize = $('#productSize').val();
            var productQty = $('#productQuantity').val();
            var productPrice = $('#productAmount').val();



            var flag = '';

            $("#productBody").find("tr").each(function () {
                var td1 = $(this).find("td:eq(0)").text();
                var td2 = $(this).find("td:eq(1)").text();

                if (productName == td1 && productSize == td2) {
                    flag = 1;
                }
            });

            if(flag == 1){
                swal("Exisiting Product" , "" , "error");
            }else {

                if(productCode == ""){

                }else{

                    var tableElements = "<tr class='text-center'> " +
                        "<td><input type='hidden' name='productCode[]' id='productCode' value='" + productCode + "'>" + productName + "</td> " +
                        "<td><input type='hidden' name='productSize[]' id='productSize' value='" + productSize + "'>" + productSize + "</td> " +
                        "<td><input type='hidden' name='productQty[]' id='productQty' value='" + productQty + "'>" + productQty + "</td> " +
                        "<td><input type='hidden' name='productPrice[]' id='productPrice' value='" + productPrice + "'>" + productPrice + "</td> " +
                        "<td><button class='btn btn-error' type='button' id='btn-remove'> Remove </button></td>" +
                        " </tr>";
                }

            }

            $('#productBody').append(tableElements);
        }



        $('#addProduct').on('click', function(){
            addProductList();
            totalProductAmount();
        });

        $(document).on('click', '#btn-remove', function(){
            $(this).closest('tr').remove();
            totalProductAmount();
        });

        $('#depCheckbox').on('click', function(){
            if($('#depCheckbox').prop('checked') == true){
                $('#depositAmt').val(0);
                $('#depositAmt').attr('readonly', false);
            }else{
                $('#depositAmt').attr('readonly', true);
            }
        });

        $('.payment').maskMoney();



    })
</script>

@endsection
