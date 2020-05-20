@extends('main')

@section('content')

    <div class="content-wrapper">
        <section class="content">
            <div class="box">
                <div class="box-header">
                    <div class="col-md-4" role="alert">
                        <br>
                        <a href="{{ route('CylinderReceipt.create') }}" class="btn btn-block btn-primary btn-flat addCustomer pull-right"> Add Cylinder Receipt</a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="box-body table-responsive">
                        <table id="salesInvoice" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th class="text-center">ICR NO.</th>
                                <th class="text-center">ICR DATE</th>
                                <th class="text-center">CUSTOMER NAME</th>
                                <th class="text-center">STATUS</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($cylinder_data as $data)
                                    <tr class="text-center">
                                        <td>{{ $data -> ICR_NO }}</td>
                                        <td>{{ $data -> ICR_DATE }}</td>
                                        <td>{{ $data -> NAME }}</td>
                                        <td>@if($data -> ICR_TAG == 0)
                                                Not Empty
                                            @else
                                                Empty
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group-vertical">
                                                <a type="button" class="btn btn-info" href=""><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#salesInvoice').dataTable();
        });
    </script>
@endsection