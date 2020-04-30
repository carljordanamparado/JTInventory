@extends('main')

@section('content')

    <div class="content-wrapper">
        <section class="content">
            <div class="box">
                <div class="box-header text-center">
                    <span> Cylinder Receipt Information </span>
                </div>
                <form method="post" id="cylinderform">
                    <div class="box-body">
                        {{ csrf_field() }}
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="">ICR NO. &nbsp;<label id="status"></label> </label>
                                    <input type="text" class="form-control" id="icrNo" name="icrNo" value="0">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="lbl" for=""> &nbsp;</label>
                                    <button type="button" class="form-control btn btn-primary btn-validate" id="icrValidate" value="invoice"> Validate ICR </button>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="lbl" for="">Cylinder DATE</label>
                                    <input type="date" id="cylinderDate" name="cylinderDate" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="lbl" for="">Customer</label>
                                    <select id="customer" name="customer">
                                        <option value=""> Choose option </option>
                                    </select>
                                </div>
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
                    </div>
                </form>
            </div>
        </section>
    </div>

@endsection

@section('scripts')

@endsection