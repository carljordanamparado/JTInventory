@extends('main')

@section('content')

  <div class="content-wrapper">
     <section class="content">
         <div class="box">
           <div class="box-header">
             <div class="col-md-4" role="alert">
               <a href="{{ route('Sales.create') }}" class="btn btn-block btn-primary btn-flat addCustomer pull-right"> Add Sales Invoice </a>
             </div>
           </div>
            <div class="box-body">
                <div class="box-body table-responsive">
                        <table id="salesInvoice" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">INVOICE NO</th>
                                    <th class="text-center">INVOICE DATE</th>
                                    <th class="text-center">CUSTOMER NAME</th>
                                    <th class="text-center">DESIGNATION</th>
                                    <th class="text-center">CONTACT NO</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach($invoice_data as $data)
                                        <tr class="text-center">
                                            <td><a data-toggle="modal" href="#myModal">{{ $data->INVOICE_NO }}</a></td>
                                            <div class="modal fade" id="myModal" role="dialog">
                                                <div class="modal-dialog">

                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Modal Header</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Some text in the modal.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <td>{{ $data->INVOICE_DATE }}</td>
                                            <td>{{ $data->NAME }}</td>
                                            <td>{{ $data->DESIGNATION }}</td>
                                            <td>{{ $data->CELL_NO }}</td>
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
         <!-- /.row -->
       </section>
   </div>

@endsection

@section('scripts')

    <script type="text/javascript">
        $(document).ready(function(){

              $('#salesInvoice').DataTable({});
        });
    </script>

@endsection
