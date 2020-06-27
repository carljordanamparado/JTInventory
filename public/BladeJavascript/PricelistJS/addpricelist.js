$(document).ready(function(){
    $('#prodPrice').maskMoney();

    $('.prodPrice').maskMoney();

            $('.btn-edit').on('click', function(){
                $(this).closest('tr').find('input,button').prop('disabled', false);
                $(this).closest('tr').find('button, .btn-edit-yes').removeClass('hidden');
                $(this).closest('tr').find('button, .btn-action').addClass('hidden');
            });

            $('.btn-no').on('click', function(){
                $(this).closest('tr').find('input,button').prop('disabled', true);
                $(this).closest('tr').find('button, .btn-edit-yes').addClass('hidden');
                $(this).closest('tr').find('button, .btn-action').removeClass('hidden');
                var oldprice = $(this).closest('tr').find('.prodPrice').attr("data-value");
                $(this).closest('tr').find('.prodPrice').val(oldprice);
            });

            $('.btn-yes').on('click', function(){
                
                var price = $(this).closest('tr').find('.prodPrice').val();
                
                var id = $(this).closest('tr').find('#prodID').val();

                $.ajax({

                    url: "/updateProductPrice",
                    type: "POST",
                    data:{
                        '_token': $('input[name=_token]').val(),
                        'id' : id,
                        'price' : price
                    },
                    success: function(response){
                        if(response.updateStatus == "true"){
                                swal({title: "Success!", text: "Product Price is updated.", type: "Success"})
                                    .then((value) => {
                                        location.reload();
                                    });

                        }else{
                          swal("Error in adding of Product", "danger");
                        }
                    },
                    error: function(jqXHR){
                        console.log(jqXHR);
                    }

                });

            });

            
            
            // $('.prodPrice').on('change',function(){
            //     var Price = $(this).closest('tr').find('.prodPrice').val();
            //     alert(Price);
            // });


});