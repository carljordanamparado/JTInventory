@extends('main')

@section('content')

    <div class="content-wrapper">

        <section class="content">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"> Add Customer Pricelist </h3>
                </div>
                <div class="box-body">


                    @foreach ($clientProduct as $row)

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
                            <label for="emailAddress">Add Balance</label>
{{--                            <input type="date" class="form-control" id="cutoffDate" data-validation="date" name="cutoffDate" placeholder="cutoffDate">--}}
                                <button class="form-control btn btn-info" data-toggle="modal" data-target="#cylinderModal"> Add Cylinder Balance </button>
                        </div>
                    </div>
            </div>

            {{-- Cylinder Modal --}}
            <div class="modal fade" id="cylinderModal" tabindex="-1" role="dialog" aria-labelledby="cylinderModal" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="cylinderModalLabel">Add Cylinder</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form role="form" method="post" id="cylinderForm" action="{{ route('CylinderController.store') }}">
                  <div class="modal-body">
                      {{ csrf_field() }}
                      <input type="hidden" name="clientid" value="{{ $row -> CLIENTID }}">
                      <label for="Products"> Products </label>
                      <select name="productCode" id="prodCode" data-validation="required" class="form-control">
                          <option value="" selected> Choose Option</option>
                          @foreach($clientProduct as $product)
                              <option value="{{ $product -> PROD_CODE }}"> {{ $product -> PRODUCT  }} - {{ $product -> SIZE }}</option>
                          @endforeach
                      </select>
                      <input type="hidden" id="prodSizes" name="prodSizes" value="">
                      <div class="form-group">
                          <label for="cutoffDate">Cut Off Date</label>
                          <input type="date" class="form-control" id="cutoffDate" name="cutoffDate" data-validation="date" aria-describedby="cutoffDate" placeholder="Enter Cut-Off Date">
                      </div>
                      <div class="form-group">
                          <label for="cylinderQty">Cylinder Qty</label>
                          <input type="number" class="form-control" id="cylinderQty" name="qtyCylinder" data-validation="number" placeholder="Enter Cylinder Qty">
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" value="validate">Save changes</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>

            {{-- Table for Product Price --}}

{{--            <div class="box">--}}
{{--                <div class="box-header">--}}
{{--                    <h3 class="box-title"> Saved Product Price </h3>--}}
{{--                </div>--}}
{{--                <div class="box-body">--}}
{{--                    <div class="row table-responsive col-md-12">--}}
{{--                        <table id="prodListTable" class="table table-bordered table-striped">--}}
{{--                            <thead>--}}
{{--                                <tr>--}}
{{--                                    <th class="text-center"> Products </th>--}}
{{--                                    <th class="text-center"> Products Size </th>--}}
{{--                                    <th class="text-center"> Product Price </th>--}}
{{--                                    <th class="text-center"> Product Date </th>--}}
{{--                                    <th class="text-center"> Action </th>--}}
{{--                                </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                                @foreach($clientProduct as $prodList)--}}
{{--                                    <tr>--}}

{{--                                        <td class="text-center"><input type="hidden" id="prodID" value="{{ $prodList-> ID }}">{{ $prodList-> PRODUCT }}</td>--}}
{{--                                        <td class="text-center">{{ $prodList-> SIZE }}</td>--}}
{{--                                        <td class="text-center"><input type="text" name="editProdPrice" class="prodPrice" value="{{ number_format($prodList-> PRODUCT_PRICE, 2) }}" data-value="{{ number_format($prodList-> PRODUCT_PRICE, 2) }}" disabled="true"></td>--}}
{{--                                        <td class="text-center">{{ $prodList-> PRICE_DATE }}</td>--}}
{{--                                        <td class="text-center">--}}

{{--                                            <div class="btn-group-vertical btn-action">--}}
{{--                                                <a type="button" class="btn btn-info btn-edit"><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>--}}
{{--                                                <a type="button" class="btn btn-warning"><span class="fa fa-trash">&nbsp;&nbsp;</span>Delete</a>--}}
{{--                                            </div>--}}

{{--                                            <div class="btn-group-vertical btn-edit-yes hidden">--}}
{{--                                                <a type="button" class="btn btn-info btn-yes"><span class="fa fa-pencil">&nbsp;&nbsp;</span>Yes</a>--}}
{{--                                                <a type="button" class="btn btn-danger btn-no"><span class="fa fa-trash">&nbsp;&nbsp;</span>No</a>--}}
{{--                                            </div>--}}

{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--            </div>--}}

        </section>

    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){

            $.validate({
              form : '#cylinderForm'
            });

           $('#prodCode').on('change', function(){
                $.ajax({
                    url: "{{ route('getProductSize2') }}?prodcode=" + $(this).val(),
                    method: 'GET',
                    success: function($data){
                        if($data == ''){
                        }else{
                            $('#prodSizes').val($data);
                        }
                    }
                });
            });

        });
    </script>


@endsection