@extends('main')

@section('content')
    @include('SalesRecord.SalesInvoice.viewinvoice')
  <div class="content-wrapper">
     <section class="content">
         <div class="box">
           <div class="box-header">

             <div class="col-md-4" role="alert">
                 <br>
               <a href="{{ route('Sales.create') }}" class="btn btn-block btn-primary btn-flat addCustomer pull-right"> Add Sales Invoice </a>
             </div>
           </div>
            <div class="box-body">
                <div class="box-body table-responsive">
                        <table id="salesInvoice" class="table table-bordered table-striped">
                            @foreach(Session::get('user') as $user)
                            @endforeach
                            <thead>
                                <tr>
                                    <th class="text-center">INVOICE NO</th>
                                    <th class="text-center">INVOICE DATE</th>
                                    <th class="text-center">CUSTOMER NAME</th>
                                    <th class="text-center">DESIGNATION</th>
                                    <th class="text-center">CONTACT NO</th>
                                    @if($user -> user_authorization == "ADMINISTRATOR" || $user->user_authorization == 1)
                                    <th class="text-center">Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach($invoice_data as $data)
                                        <tr class="text-center">
                                            <td><a href="#invoiceModal" id="invoiceData" data-toggle="modal" data-target="#invoiceModal">{{ $data->INVOICE_NO }}</a></td>
                                            <td>{{ $data->INVOICE_DATE }}</td>
                                            <td>{{ $data->NAME }}</td>
                                            <td>{{ $data->DESIGNATION }}</td>
                                            <td>{{ $data->CELL_NO }}</td>
                                            @if($user -> user_authorization == "ADMINISTRATOR" || $user->user_authorization == 1)
                                            <td class="text-center">
                                                <div class="btn-group-vertical">
                                                    <a type="button" class="btn btn-info" href="{{ route('Sales.edit', $data->ID) }}"><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                                                </div>
                                            </td>
                                            @endif
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

    <script type="text/javascript">

        $(document).ready(function(){

            $('#salesInvoice').DataTable({
                "paging":   true,
                "ordering": true,
                "info":     true,
                'searching': true,
                'bJQueryUI': true
            });

            $(document).on('click', '#invoiceData',  function(){
                var id = $(this).text();

                $.ajax({
                    url: "{{ route('invoiceModal') }}",
                    method: 'GET',
                    data:
                        {
                            'id': id,
                        },
                    success: function(response){
                        $('#Deposit').val(response.dataArray[0].Deposit.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                        $('#Downpayment').val((response.dataArray[0].Downpayment).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                        $('#Type').val(response.dataArray[0].Type);
                        $('#totalAmt').val(response.dataArray[0].Total.replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                        $('#invoiceDetails').empty();
                        $('#particularProduct').empty();
                        $('#invoiceDetails').append(response.table_data);
                        $('#particularProduct').append(response.table_data2);
                    }
                });
            });

        });
    </script>

@endsection
