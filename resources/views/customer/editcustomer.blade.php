@extends('main')

@section('content')

    <div class="content-wrapper">

        <section class="content">



            <div class="box">
                <div class="box-header">
                    <div class="" role="alert">
                        <h3 class="box-title">Customer Information</h3>
                    </div>
                </div>
                @foreach ($client as $row)

                @endforeach
                <div class="box-body">
                    <form role="form" action="{{ route('CustomerController.update', $row -> CLIENTID) }}"  method="POST" >

                        {{ method_field('PUT') }}
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="CustomerName">Customer Name</label>
                                <input type="text" class="form-control" data-validation="required" id="custName" name="custName" placeholder="Customer Name" value="{{ $row -> NAME  }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="Address">Address</label>
                                <input type="text" class="form-control" data-validation="required" id="Address" name="Address" placeholder="Address" value="{{ $row -> ADDRESS }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="CityMuni">City/Municipality</label>
                                <input type="text" class="form-control" data-validation="required" id="City" name="City" placeholder="City" value="{{ $row -> CITY_MUN }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="CustomerName">Customer Type</label>
                                <select name="custType" id="custType" data-validation="required" class="form-control">
                                    <option value="" selected>Choose option</option>
                                    @foreach ($clientType as $cType)
                                        <option value="{{ $cType -> ID}}" {{ ( $cType->ID == $row -> TYPE) ? 'selected' : '' }} >{{ $cType -> CLIENT_TYPE}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">

                            <div class="form-group col-md-3">
                                <label for="Customer Since">Customer Since</label>
                                <input type="date" class="form-control" data-validation="date" id="custSince" name="custSince" value="{{ $row -> CLIENT_DATE }}" >
                            </div>
                            <div class="form-group col-md-3">
                                <label for="tinNo">Tin NO.</label>
                                <input type="text" class="form-control" id="tinNo" name="tinNo" placeholder="Tin NO."value="{{ $row -> DTI_NO }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="contPerson">Contact Person</label>
                                <input type="text" class="form-control" data-validation="required" id="contPerson" name="contPerson" placeholder="Contact Person" value="{{ $row -> CON_PERSON }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="Designation">Designation</label>
                                <input type="text" class="form-control" id="Designation" data-validation="required" name="Designation" placeholder="Designation" value="{{ $row -> DESIGNATION }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="telNumber">Telephone No.</label>
                                <input type="text" class="form-control" id="telNo" name="telNo" placeholder="Telephone NO." value="{{ $row -> TEL_NO }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="contNumber">Contact No.</label>
                                <input type="text" class="form-control" id="contNo" name="contNo" placeholder="Contact NO." value="{{ $row -> CELL_NO }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="emailAddress">Email Address</label>
                                <input type="text" class="form-control" id="emailAddress" data-validation="email" name="emailAddress" placeholder="Email Address" value="{{ $row -> EMAIL_ADDR }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                &nbsp;
                            </div>
                            {{-- <div class="form-group col-md-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="cashPayment" id="cashPayment">
                                        Cash Payment
                                        <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                                       Original Copy
                                        <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                                      Pink Copy
                                    </label>
                                </div>
                            </div> --}}
                            <div class="form-group col-md-4">
                                {{ $row -> PAYMENT_TYPE }}
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="cashPay" id="cashPay" @if($row -> PAYMENT_TYPE == 1) checked="checked" @endif value="" >Cash Payment
                                </label>
                                &nbsp;&nbsp;&nbsp;
                                <label class="radio-inline">
                                    <input type="radio" name="orCopy" id="origCopy" @if( floatval($row -> ORCOPY) == 1) checked="checked" @else @endif value="1">Original Copy
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="orCopy" id="pinkCopy" @if( floatval($row -> ORCOPY) == 2) checked="checked" @else @endif value="2">Pink Copy
                                </label>
                            </div>

                            <div class="form-group col-md-4">

                            </div>



                        </div>

                        <div class="btn-group pull-right">
                            <button type="submit" class="btn btn-primary ">Submit</button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary pull-left">Back</button>
                        </div>
                        <div class="btn-group">
                            <button type="button" id="btnClear" class="btn btn-primary pull-left">Clear</button>
                        </div>
                        <div class="btn-group">
                            <button type="button" id="btnClear" class="btn btn-primary pull-left">Masterlist</button>
                        </div>
                    </form>
                </div>

            </div>
            <!-- /.row -->
        </section>

    </div>


@endsection

@section('scripts')
    <script type="text/javascript">

        $.validate({});

        $(document).ready(function(){

            $('#cashPay').on('click', function(){
                var checked = document.getElementById('cashPay').checked;
                console.log(checked);
                if(checked == true){
                    $('#cashPay').val("1");
                }else{
                    $('#cashPay').val("0");
                }
            });

        });


    </script>

@endsection