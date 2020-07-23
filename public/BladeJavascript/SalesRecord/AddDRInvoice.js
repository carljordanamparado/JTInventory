$(document).ready(function(){

    // $('#salesDetails').hide();
    // $('.product').hide();
    $('#unitPrice').maskMoney();
    $('#downPay').maskMoney();


    $('#cancelInvoice').on('click', function(){
        window.history.back();
    });

    $(document).on('change', '#custDetails' , function(){
        load_purchaseOrder();
    });

    function load_purchaseOrder(){

        var cust_id = $('#custDetails option:selected').val();


        $.ajax({
            url: "/customer_po",
            type: "POST",
            data:{
                '_token': $('input[name=_token]').val(),
                'cust_id' : cust_id,
            },
            success: function(response){
                if(response.option != ""){
                    $('#poNo').attr("disabled", false);
                    $('#poNo').empty().append("<option value=''> Choose Option </option> ");
                    $('#poNo').append(response.option);
                    $('.poNo').select2({
                        placeholder: 'Select an option',
                        dropdownAutoWidth: true,
                        allowClear: true
                    });
                }else{
                    $('.poNo').select2({
                        placeholder: 'Select an option',
                        dropdownAutoWidth: true,
                        allowClear: true
                    });
                    $('#poNo').attr("disabled", false);
                    $('#poNo').empty().append("<option value=''> Choose Option </option> ");
                }

                if(response.option2 != ""){
                    $('#priceDate').attr("disabled", false);
                    $('#priceDate').empty().append("<option value=''> Choose Option </option> ");
                    $('#priceDate').append(response.option2);
                    $('.priceDate').select2({
                        placeholder: 'Select an option',
                        dropdownAutoWidth: true,
                        allowClear: true
                    });
                }else{
                    $('.priceDate').select2({
                        placeholder: 'Select an option',
                        dropdownAutoWidth: true,
                        allowClear: true
                    });
                    $('#priceDate').attr("disabled", false);
                    $('#priceDate').empty().append("<option value=''> Choose Option </option> ");

                }

            },
            error: function(jqXHR){
                console.log(jqXHR);
            }
        });
    }


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
        var finalAmount = "";

        // $("#productBody tr td:nth-child(3)").each(function () {
        //     var data = parseFloat($(this).text().replace(/,/g, ''));
        //     totalAmount = parseFloat(data);
        // });
        //
        // $("#productBody tr td:nth-child(4)").each(function () {
        //     var data = parseFloat($(this).text().replace(/,/g, ''));
        //     totalQty = parseFloat( data);
        //     finalAmount = parseFloat(finalAmount) + parseFloat(totalAmount * totalQty);
        // });

        $("#productBody tr").each(function () {
            var amount = parseFloat( $(this).find("td:eq(2)").text().replace(/,/g, ''));
            var qty = parseFloat($(this).find("td:eq(3)").text().replace(/,/g, ''));
            finalAmount = parseFloat(finalAmount + (amount *qty ));
        });

        var otherCharges = parseFloat($('#otherCharge').val().replace(/,/g, ''));

        var totalCharges = parseFloat(finalAmount + otherCharges) ;

        $('#grandTotal').val(totalCharges.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        $('#balAmount').val(totalCharges.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    }


    $('#addParticular').on('click', function(){
        addParticular();
        clearForm();
        totalOtherCharges();
        totalProductAmount();
        computation();
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
                    $('#status').text("No Record Found");
                    $('#status').css("color", "red");
                    $('#status').css('font-size', '12px');
                    $('#issuedBy').val("");
                    // $('#salesDetails').hide();
                    $('#submitButton').attr('disabled', true);
                }else if(response.status == "DONE" || response.status == 'CANCELLED' || response.status == 'NO RECORD FOUND'){
                    $('#status').text(response.status);
                    $('#status').css("color", "red");
                    $('#status').css('font-size', '12px');
                    $('#issuedBy').val("");
                    // $('#salesDetails').hide();
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

    function clearProductInfo(){
        $('#productSize').val("");
        $('#productQuantity').val("");
        $('#productAmount').text("");
        $('#productAmount').val("");
    }

    function customerDetailsAndDate(){
        var cust_id = $('#custDetails option:selected').val();
        var price_date = $('#priceDate option:selected').val();
        $.ajax({
            url: "/poCustomerDetails",
            type: "POST",
            data:{
                '_token': $('input[name=_token]').val(),
                'cust_id' : cust_id,
                'price_date' : price_date
            },
            success: function(response){
                /*$('#CustDetails option').remove();
                $('#CustDetails').append(response.html);
                $('#CustDetails').attr("readonly", true);
                // $('#CustDetails').hide();
                $('#custName').val(response.html2);*/
                $('#poDate').val(response.date);
                $('#productQuantity').val(0);
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
        var prodId = $('#productItem option:selected').attr('data-id');
        var po_id = $('#poNo option:selected').text()
        var price_date = $('#priceDate option:selected').val();
        var cust_id = $('#priceDate option:selected').attr("custId");
        $.ajax({
            url: "/poProductDetails",
            type: "POST",
            data:{
                '_token': $('input[name=_token]').val(),
                'prodCode' : prodCode,
                'po_id' : po_id,
                'cust_id' : cust_id,
                'price_date' : price_date,
                'prodId' : prodId
            },
            success: function(response){
                $('#productSize').val(response.size);
                $('#remQuantity').val(response.quantity)
                $('#productQuantity').val(0);
                $('#remQuantity').val(0);
                var amount = (response.amount);
                $('#productAmount').val(amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            },
            error: function(jqXHR){
                console.log(jqXHR);
            }
        });
    }

    $('#priceDate, #poNo').on('change', function(){
        customerDetailsAndDate();
        clearProductInfo();
        clearForm();
        $('#productBody').empty();
        $('.product').show();
    });

    $('#productItem').on('change', function(){
        if($('#productItem option:selected').val() == ""){
            clearProductInfo();
        }else{
            productDetails();
        }

    });

    function checkIfQtyisInputted(){

        var input_qty = parseFloat($('#productQuantity').val());
        var rem_qty = parseFloat($('#remQuantity').val());
        var po_no = $('#poNo option:selected').val();

        console.log(po_no);

        if(input_qty > rem_qty && po_no != ""){
            swal("Inputted Qty is higher than Remaining Qty" , "Please input again" , "error");
            $('#productQuantity').val(0);
        }else{

        }

    }

    $(document).on('keyup', '#productQuantity', function(){
        checkIfQtyisInputted();
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

            if (productName == td1 && productSize == td2 && parseFloat(productQty) == 0 ) {
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
                    "<td><input type='hidden' name='productPrice[]' id='productPrice' value='" + productPrice + "'>" + productPrice + "</td> " +
                    "<td><input type='hidden' name='productQty[]' id='productQty' value='" + productQty + "'>" + productQty + "</td> " +
                    "<td><button class='btn btn-error' type='button' id='btn-remove'> Remove </button></td>" +
                    " </tr>";
            }

        }

        $('#productBody').append(tableElements);
    }

    $('#addProduct').on('click', function(){
        addProductList();
        totalProductAmount();
        computation();
    });

    $(document).on('click', '#btn-remove', function(){
        $(this).closest('tr').remove();
        totalProductAmount();
        computation();
    });


    $('#depCheckbox').on('click', function(){
        if($('#depCheckbox').prop('checked') == true){
            $('#depositAmt').val("0.00");
            $('#depositAmt').maskMoney();
            $('#depositAmt').attr('readonly', false);
        }else{
            $('#depositAmt').val("0.00");
            $('#depositAmt').maskMoney('destroy');
            $('#depositAmt').attr('readonly', true);
        }
    });

    function computation(){
        // Inputted Data
        var downpayment = parseFloat($('#downPay').val().replace(/,/g, ''));
        var deposit = parseFloat($('#depositAmt').val().replace(/,/g, ''));

        var sumofTwo = downpayment + deposit;

        // Fetched Data

        var totalAmt =  parseFloat($('#grandTotal').val().replace(/,/g, ''));

        var productBody = $('#productBody').text().trim();
        console.log(productBody);

        if(productBody == ''){
            $('#balAmount').val(deposit - downpayment);
            $('#grandTotal').val(deposit);
        }else{
            if(sumofTwo > totalAmt){
                var finalBalance = totalAmt ;
                $('#depositAmt').val("0.00");
                $('#downPay').val("0.00");
                swal("Computation cannot proceed","Check inputted amount!!","error");
                $('#balAmount').val(finalBalance.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            }else{
                var finalBalance = totalAmt - sumofTwo ;
                $('#balAmount').val(finalBalance.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            }
        }


        // Init Computation



    }

    $(document).on('keyup', '#downPay,#depositAmt', function(){
        computation();
    });

    function validateCylinder(){

        var cylinder_type = $('#cylinderType option:selected').val();
        var id = $('#inputtedTypeId').val();

        $.ajax({
            url: "/validateCylinderType",
            type: "POST",
            data:{
                '_token': $('input[name=_token]').val(),
                'cylinder_type' : cylinder_type,
                'id' : id
            },
            success: function(response){
                $('#CustDetails option').remove();
                $('#CustDetails').append(response.html);
                $('#CustDetails').attr("readonly", true);
                // $('#CustDetails').hide();
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

    $('#validateCylinder').on('click', function(){
        validateCylinder();
    });


});