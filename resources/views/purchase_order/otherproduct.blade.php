<div class="modal fade" id="otherModal" tabindex="-1" role="dialog" aria-labelledby="otherModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Other Charges Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="">PARTICULARS</label> </label>
                        <input type="text" class="form-control" id="particular">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="">UNIT PRICE</label> </label>
                        <input type="text" class="form-control" id="unitPrice">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="">QUANTITY</label> </label>
                        <input type="text" class="form-control" id="Quantity">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addParticular">Add Particular</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
        <script type="text/javascript">
            $(document).ready(function(){
                $('#unitPrice').maskMoney();

                function addParticular(){
                    var particular = $('#particular').val();
                    // var unitPrice = parseFloat($('#unitPrice').val().replace(/,/g, '')); // Remove Comma in Parse Float Value
                    var unitPrice = $('#unitPrice').val();
                    var qty = parseFloat($('#Quantity').val());

                    var tableElements = "<tr class='text-center'> " +
                        "<td><input type='hidden' name='particular[]' id='particular' value='" + particular + "'>" + particular + "</td> " +
                        "<td><input type='hidden' name='unitPrice[]' id='unitPrice' value='" + unitPrice + "'>" + unitPrice + "</td> " +
                        "<td><input type='hidden' name='productQty[]' id='productQty' value='" + productQty + "'>" + productQty + "</td> " +
                        "<td><button class='btn btn-error' type='button' id='btn-remove'> Remove </button></td>" +
                        " </tr>";

                }

                $('#addParticular').on('click', function(){
                    addParticular();
                });
            });
        </script>
@endsection