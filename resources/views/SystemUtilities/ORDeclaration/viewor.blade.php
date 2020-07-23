@extends('main')

@section('content')

    <div class="content-wrapper">
     <section class="content">
         <div class="box">
           <div class="box-header text-center">
               <span> Sales Representative </span>
{{--               <a href="{{ route('SalesInvoice.create') }}" class="btn btn-block btn-primary btn-flat addCustomer pull-right"> Add Sales Invoice Declaration </a>--}}
           </div>
           <div class="box-body">
                <div class="box-body table-responsive">
                        <table id="salesRep" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">SalesRep Nickname</th>
                                    <th class="text-center">Sales Fullname</th>
                                    <th class="text-center">Designation</th>
                                    <th class="text-center">Address</th>
                                    <th class="text-center">Birthdate</th>
                                    <th class="text-center">Contact No.</th>
                                    <th class="text-center">Email Address</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($salesRep as $salesrep)
                                    <tr class="text-center">
                                        <td>{{ $salesrep -> SALESREP_NAME }}</td>
                                        <td>{{ $salesrep -> LASTNAME }} , {{ $salesrep -> FIRSTNAME }} {{ $salesrep -> MIDDLENAME }}</td>
                                        <td>{{ $salesrep -> DESIGNATION }}</td>
                                        <td>{{ $salesrep -> ADDRESS }}</td>
                                        <td>{{ $salesrep -> BIRTH_DATE }}</td>
                                        <td>{{ $salesrep -> CONTACT_NO }}</td>
                                        <td>{{ $salesrep -> EMAIL }}</td>
                                        <td class="text-center">
                                            <div class="btn-group-vertical">
                                                 <a type="button" class="btn btn-info" href=" {{ route('ORController.create', $salesrep -> ID) }}">
                                                     <span class="fa fa-pencil">&nbsp;&nbsp;</span>
                                                     Add OR
                                                 </a>
{{--                                                <a type="button" class="btn btn-info" href=" {{ route('SalesInvoice.show', $salesrep -> ID) }}"><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit Invoice</a>--}}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                      </div>
           </div>
         </div>
         <!-- /.row -->
       </section>
   </div>

@endsection

@section('scripts')
    <script>
        $(document).ready( function(){
            $('#salesRep').DataTable({
                "paging":   true,
                "ordering": true,
                "info":     true,
                'searching': true,
                'bJQueryUI': true
            });
        });
    </script>
@endsection