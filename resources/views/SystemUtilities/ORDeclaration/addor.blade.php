@extends('main')

@section('content')

  <div class="content-wrapper">

   <section class="content">
       <div class="box">
          <div class="box-header text-center">
            <span> Add OR Declaration </span>
          </div>
           <form method="post" action="{{ route('ORDeclaration.store') }}">
               <div class="box-body">
                   {{ csrf_field() }}
                   <div class="row">
                       <input type="hidden" name="id" value="{{ $id }}" >
                       <div class="form-group col-md-3">
                         <label for=""> Date Assigned </label>
                         <input type="date" class="form-control" id="DateAssign" name="DateAssign" placeholder="Enter Nickname">
                       </div>
                       <div class="form-group col-md-3">
                         <label for=""> From Invoice No. </label>
                         <input type="text" class="form-control" id="FromInvoice" name="FromInvoice" placeholder="Enter From Invoice No.">
                       </div>
                       <div class="form-group col-md-3">
                         <label for=""> To Invoice No. </label>
                         <input type="text" class="form-control" id="ToInvoice" name="ToInvoice" placeholder="Enter To Invoice No.">
                       </div>
                       <div class="form-group col-md-3">
                         <label for=""> Assigned By: </label>
                         <input type="text" class="form-control" id="assignedBy" name="assignedBy" value="Sample User" placeholder="" readonly>
                       </div>
                   </div>
               </div>
               <div class="box-footer">
                   <div class="row">
                       <div class="form-group col-md-4 pull-right">
                           <button type="submit" id="addSalesInvoice" class="form-control btn btn-primary"> Add OR Decleration </button>
{{--                           <a href="{{ route('SalesInvoice.index') }}" class="form-control btn btn-primary"> Back</a>--}}
                       </div>
                   </div>
               </div>
               </form>
       </div>

       <div class="box">
          <div class="box-header text-center">
            <span> OR Declaration </span>
          </div>

          <div class="box-body">
                <div class="table-responsive">
                        <table id="salesRep" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">From</th>
                                    <th class="text-center">To</th>
                                    <th class="text-center">Assigned Date</th>
                                    <th class="text-center">Assigned By</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($dr as $dr)
                                    <tr class="text-center">
                                        <td>{{ $dr -> ID }}</td>
                                        <td>{{ $dr -> FROM_OR_NO }} </td>
                                        <td>{{ $dr -> TO_OR_NO }}</td>
                                        <td>{{ $dr -> ENCODED_DATE }}</td>
                                        <td>{{ $dr -> ASSIGNED_BY }}</td>
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
