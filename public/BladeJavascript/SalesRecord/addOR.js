$(document).ready(function(){

    $('#customer').select2();

    $(document).on('click', '#cancelInvoice', function () {
        window.history.back();
    });

    function idValidation() {

        var orNo = $('#orNo').val();
        var buttonVal = $('#invoiceValidate').val();

        $.ajax({
            url: "/noValidate",
            type: "POST",
            data:{
                '_token': $('input[name=_token]').val(),
                'invoiceNo' : orNo,
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
                    $('#cancelInvoice').val(response.issuedBy);
                    $('#issuedId').val(response.issuerID);
                    $('#salesDetails').show();
                    $('#submitButton').attr('disabled', false);
                }
            },
            error: function(jqXHR){
                console.log(jqXHR);
            }
        });
    }

    $('#invoiceValidate').on('click', function () {
        idValidation();
    });

    function client_sales_invoice(){
        var client_id = $('#customer option:selected').val();

        $.ajax({
            url: "/getClientSalesInvoice",
            type: "POST",
            data:{
                '_token': $('input[name=_token]').val(),
                'client_id' : client_id
            },
            success: function(response){
                $('#productBody').empty();
                $('#productBody').append(response.table_data2);
            },
            error: function(jqXHR){
                console.log(jqXHR);
            }
        });
    }

    $('#customer').on('change', function(){
        client_sales_invoice();
    });

    $(document).on('click', '#radioButton', function(){

        if($(this).prop("checked") == true){
           var rowValue =  $(this).closest("tr");

           var firstTd = rowValue.find("td:eq(1)").text();
           var secondTd = rowValue.find("td:eq(2)").text();
           var thirdTd = rowValue.find("td:eq(3)").text();

           var tableData = "<tr class='text-center'> " +
               "<td> "+ firstTd + "</td> " +
               "<td> "+ secondTd + "</td> " +
               "<td>" + thirdTd + "</td> " +
               "<td> <input type='radio' id='radButton' name='radButton'> P/O </td>" +
               "</tr>";

           $('#productBody2').append(tableData);
        }else{
            var rowValue =  $(this).closest("tr");

            var firstTd = rowValue.find("td:eq(1)").text().trim();

            $("#productBody2").find("tr").each(function () {

                if ($(this).find('td:contains('+firstTd+')').text().trim() == firstTd) {
                    $(this).closest('tr').remove();
                }
            });


        }

    });



});