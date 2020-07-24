@extends('main')

@section('content')


    <div class="content-wrapper">
        <section class="content">
            <div class="box">
                <div class="box-header text-center">
                    <div class="col-md-4" role="alert">
                        <br>
                        <a href="{{ route('OfficialReceipt.create') }}" class="btn btn-block btn-primary btn-flat addCustomer pull-right"> Add Official Receipt</a>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <table id="delivery" class="table table-bordered table-striped">
                        <thead>
                        <th class="text-center"> OR No. </th>
                        <th class="text-center"> OR Date. </th>
                        <th class="text-center"> Customer Name </th>
                        <th class="text-center"> Actions </th>
                        </thead>
                        <tbody>
                        @foreach($OR as $DATA)
                            <tr class="text-center">
                                <td> {{ $DATA -> OR_NO }}</td>
                                <td> {{ $DATA -> OR_DATE }}</td>
                                <td> {{ $DATA -> NAME }}</td>
                                <td><a type="button" class="btn btn-info" href=""><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.row -->
        </section>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $('#delivery').DataTable();
        });
    </script>
@endsection