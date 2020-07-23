@extends('main')

@section('content')

    <div class="content-wrapper">

        <section class="content">
            <div class="box">
                <div class="box-header text-center">
                    <span> Add Sales Invoice Declaration </span>
                </div>
                @foreach($declaration as $data)
                @endforeach
                <form method="post" action="{{ route('updateSD') }}">
                    <div class="box-body">
                        {{ csrf_field() }}
                        <div class="row">
                            <input type="hidden" name="salesid" value="{{ $data->SALESREP_ID }}">
                            <input type="hidden" name="id" value="{{ $data->ID }}" >
                            <div class="form-group col-md-3">
                                <label for=""> Date Assigned </label>
                                <input type="date" class="form-control" id="DateAssign" name="DateAssign" value="{{ $data->ENCODED_DATE }}" placeholder="Enter Nickname">
                            </div>
                            <div class="form-group col-md-3">
                                <label for=""> From Invoice No. </label>
                                <input type="text" class="form-control" id="FromInvoice" name="FromInvoice" value="{{ $data->FROM_OR_NO }}" placeholder="Enter From Invoice No.">
                            </div>
                            <div class="form-group col-md-3">
                                <label for=""> To Invoice No. </label>
                                <input type="text" class="form-control" id="ToInvoice" name="ToInvoice" value="{{ $data->TO_OR_NO }}" placeholder="Enter To Invoice No.">
                            </div>
                            <div class="form-group col-md-3">
                                @foreach(Session::get('user') as $user)
                                @endforeach
                                <label for=""> Assigned By: </label>
                                <input type="text" class="form-control" id="assignedBy" name="assignedBy" value="{{ $user->userid }}" placeholder="" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="form-group col-md-4 pull-right">
                                <button type="submit" id="addSalesInvoice" class="form-control btn btn-primary"> Edit Sales Invoice Declaration </button>
                                {{--                           <a href="{{ route('SalesInvoice.index') }}" class="form-control btn btn-primary"> Back</a>--}}
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- /.row -->
        </section>

    </div>

@endsection


@section('scripts')
    <script>
    </script>
@endsection
