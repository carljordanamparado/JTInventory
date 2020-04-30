<div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title text-center" id="exampleModalLabel">Invoice Information</h5>
            </div>
            <div class="modal-body">
                <h5 class="modal-title text-center" id="exampleModalLabel">Order List</h5>
                <div class="box-body table-responsive">
                    <table id="" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">Product</th>
                            <th class="text-center">Product Size</th>
                            <th class="text-center">Product Qty</th>
                            <th class="text-center">Product Price</th>
                        </tr>
                        </thead>
                        <tbody id="invoiceDetails">


                        </tbody>
                    </table>
                </div>
                <h5 class="modal-title text-center" id="exampleModalLabel">Particular Order List</h5>
                <div class="box-body table-responsive">
                    <table id="" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">Particular</th>
                            <th class="text-center">Particular Qty</th>
                            <th class="text-center">Particular Price</th>
                        </tr>
                        </thead>
                        <tbody id="particularProduct">


                        </tbody>
                    </table>
                </div>
                <h5 class="modal-title text-center" id="exampleModalLabel">Order Information</h5>
                <hr>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="">Deposit</label>
                        <input type="text" class="form-control" id="Deposit"  value="" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Downpayment</label>
                        <input type="text" class="form-control" id="Downpayment" value="" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Payment Type</label>
                        <input type="text" class="form-control" id="Type"  value="" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Total Amount</label>
                        <input type="text" class="form-control" id="totalAmt" value="" readonly>
                    </div>
                </div>

            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

