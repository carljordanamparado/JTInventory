@extends('main')

@section('content')
    <style>
        .select2 {
            width:100%!important;
        }
    </style>

    <div class="content-wrapper">
        <section class="content">
            <div class="box">
                <div class="box-header">
                    <div class="col-md-4" role="alert">
                        <a href="{{ route('Deliver.create') }}" class="btn btn-block btn-primary btn-flat addCustomer pull-right"> Add Delivery </a>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <table id="delivery" class="table table-bordered table-striped">
                        @foreach(Session::get('user') as $user)
                        @endforeach
                        <thead>
                            <th class="text-center"> Delivery No. </th>
                            <th class="text-center"> Delivery Date. </th>
                            <th class="text-center"> Customer Name </th>
                            @if($user -> user_authorization == "ADMINISTRATOR" || $user->user_authorization == 1)
                                <th class="text-center"> Actions </th>
                            @endif
                        </thead>
                        <tbody>
                        @foreach($deliver_receipt as $deliver_data)
                            <tr class="text-center">
                                <td> {{ $deliver_data -> DR_NO }}</td>
                                <td> {{ $deliver_data -> DR_DATE }}</td>
                                <td> {{ $deliver_data -> NAME }}</td>
                                @if($user -> user_authorization == "ADMINISTRATOR" || $user->user_authorization == 1)
                                    <td>
                                        <a type="button" class="btn btn-info" href="{{ route('Deliver.edit', $deliver_data->ID) }}"><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                                    </td>
                                @endif
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
            $('#delivery').DataTable({
                "paging":   true,
                "ordering": true,
                "info":     true,
                'searching': true,
            });
        });
    </script>
@endsection