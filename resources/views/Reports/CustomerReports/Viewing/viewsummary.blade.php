<div class="modal fade" id="agingAccount" tabindex="-1" role="dialog" aria-labelledby="statementAccount" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Aging of Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="statement" action="{{ route('aging_account') }}"  method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for=""> CUSTOMER DETAILS </label>
                            <select id="summary" class="form-control summary" name="custDetails">
                                <option value="" custId="">Choose Option</option>
                            </select>
                            {{--<input type="text" id="custName" class="form-control">--}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="reportButton" class="btn btn-primary">Generate Report</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

