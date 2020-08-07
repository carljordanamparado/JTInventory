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
            <div class="box">
                <div class="box-header text-center">
                    <span> Cylinder Receipt Information </span>
                </div>
                <form method="post" id="cylinderform">
                    <div class="box-body">
                        @foreach($icr as $icr)
                        @endforeach
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{$icr->ID}}">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="">ICR NO. &nbsp;<label id="status"></label> </label>
                                <input type="text" class="form-control" id="icrNo" name="icrNo" value="{{ $icr -> ICR_NO }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="lbl" for=""> &nbsp;</label>
                                <button type="button" class="form-control btn btn-primary btn-validate" id="icrValidate" value="icr"> Validate ICR </button>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="lbl" for="">Cylinder DATE</label>
                                <input type="date" id="cylinderDate" name="cylinderDate" class="form-control" value="{{ $icr -> ICR_DATE}}">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="lbl" for="">Customer</label>
                                <select id="customer" name="customer" class="form-control">
                                    <option value=""> Choose option </option>
                                    @foreach($data as $client_data)
                                        <option value="{{ $client_data -> CLIENTID }}" {{ ( $client_data->CLIENTID == $icr -> CLIENT_NO) ? 'selected' : '' }}> {{ $client_data -> CLIENT_CODE }} - {{ $client_data -> NAME  }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for=""> PRODUCT </label>
                                <select id="product" class="form-control">
                                    <option value=""> Choose option </option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for=""> PRODUCT SIZE </label>
                                <input type="text" class="form-control" id="size" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label for=""> PRODUCT QTY </label>
                                <input type="text" class="form-control" id="quantity">
                            </div>
                            <div class="form-group col-md-3">
                                <label for=""> Actions </label>
                                <button type="button" class="btn-info form-control" id="addProduct"> Add Product</button>
                            </div>
                        </div>
                            <div class="row">
                                <div class="box-header text-center">
                                    <span> Added Product List </span>
                                </div>

                                <div class="row table-responsive col-md-12">
                                    <table id="prodListTable" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th class="text-center"> Product </th>
                                            <th class="text-center"> Products Size </th>
                                            <th class="text-center"> Product Qty </th>
                                        </tr>
                                        </thead>
                                        <tbody id="">
                                        @foreach($product as $product)
                                            <tr class="text-center">
                                                <td>{{ $product -> PRODUCT }}</td>
                                                <td>{{ $product -> SIZE }}</td>
                                                <td> {{ $product ->  QUANTITY }}</td>
                                                {{--<td>
                                                    <button type="button" class="btn btn-warning" id="deleteButton" value="{{ $product -> ID }}">Delete</button>
                                                </td>--}}
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <div class="row">
                            <div class="box-header text-center">
                                <span> Product List </span>
                            </div>

                            <div class="row table-responsive col-md-12">
                                <table id="prodListTable" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th class="text-center"> Product </th>
                                        <th class="text-center"> Products Size </th>
                                        <th class="text-center"> Product Qty </th>
                                        <th class="text-center"> Action </th>
                                    </tr>
                                    </thead>
                                    <tbody id="productBody">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group col-md-4">
                                <label class="checkbox-inline">
                                    <input type="radio" class="radButton" name="cylinderType" value="1" {{ ( $icr -> REFILL == "1") ? 'checked' : '' }}> For Refilling
                                </label>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="checkbox-inline">
                                    <input type="radio" class="radButton" name="cylinderType" value="2" {{ ( $icr -> RETURNED == 1 || $icr -> RETURNED == 2) ? 'checked' : '' }}> For Return of Cylinder Loan
                                </label>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="checkbox-inline">
                                    <input type="radio" class="radButton" id="otherRadio" name="cylinderType" value="3" {{ ( $icr -> OTHERS == 1 || $icr -> OTHERS == 3) ? 'checked' : '' }}> Others
                                </label>
                                &nbsp;
                                <label>
                                    <input type="text" class="form-control" name="OtherDescription" id="otherDesc" value="{{ $icr -> OTHERS_TEXT }}" readonly>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for=""> Released By </label>
                                <input type="text" class="form-control" name="releasedBy" value="{{ $icr -> SALESREP_NAME }}" readonly>
                            </div>
                            <div class="form-group col-md-4">
                                <label for=""> Received Date </label>
                                <input type="date" class="form-control" name="releasedDate" value="{{ $icr -> RECEIVED_DATE }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for=""> Received By </label>
                                <input type="text" class="form-control" name="receivedBy" value="{{ $icr -> RELEASEDBY }}">
                            </div>
                        </div>

                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="form-group col-md-3 pull-left">
                                <button type="button" id="cancelInvoice" class="form-control btn btn-primary"> Cancel Invoice </button>
                            </div>
                            <div class="form-group col-md-3 pull-right">
                                <button type="button" id="submitButton" class="form-control btn btn-primary"> Add Cylinder Receipt </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('BladeJavascript/SalesRecord/AddICR.js') }}"></script>
    <script type="text/javascript" >
        $(document).ready(function(){

            function submitButton(){

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('UpdateICR') }}" ,
                    type: "POST",
                    data: $('#cylinderform').serialize(),
                    success: function(response){
                        try{
                            swal('Incoming Cylinder Receipt successfully edited', '', 'success');
                            location.reload();
                        }catch (Exception) {
                            swal(Exception , Exception , 'error');
                        }
                    },
                    error: function(jqXHR){
                        console.log(jqXHR);
                    }
                });
            }

            $('#submitButton').on('click', function(e){
                e.preventDefault();
                submitButton();
            });
        });
    </script>
@endsection