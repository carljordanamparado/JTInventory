@extends('main')



@section('content')

    <style>

        .dataTables_wrapper .dataTables_length {
        float: left;
        }
        .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        }
        .addCustomer{
           
        }
        
    </style>

    <div class="content-wrapper">

        <section class="content">



            <div class="box">
              <div class="box-header">
                <div class="col-md-2" role="alert">
                  <a href="{{ route('CustomerController.create') }}" class="btn btn-block btn-primary btn-flat addCustomer pull-right"> Add Customer </a>
              </div>
{{--                  @if( Session::get('status') == "True" )--}}
{{--                      <input type="text" id="notifAlert" value="1">--}}
{{--                  @endif--}}
{{--                  @if( Session::get('statusUpdate') == "True" )--}}
{{--                      <input type="text" id="updateNotif" value="1">--}}
{{--                  @endif--}}
              </div>
              <div class="box-body">
                  @foreach(Session::get('user') as $user)
                  @endforeach
                <div class="row-content">
                  <div class="col-12">
                    <div class="box">
                      <div class="box-header">
                        <h3 class="bpx-title">Customer List </h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="box-body table-responsive">

                        <table id="customerTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{$user -> user_authorization}}</th>
                                    <th>Customer Name</th>
                                    <th>Customer Type</th>
                                    <th>Address</th>
                                    <th>City/Municipality</th>
                                    <th>Contact Person</th>
                                    <th>Designation</th>
                                    <th>Tel. NO</th>
                                    <th>Cell. No</th>
                                    <th>Email Addres</th>
                                    @if($user -> user_authorization == "ADMINISTRATOR" || $user -> user_authorization == 1)
                                        <th>Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($client as $row)
                                    <tr>
                                        <td>{{ $row -> CLIENT_CODE }}</td>
                                        <td>{{ $row -> NAME }}</td>
                                        <td>{{ $row -> CLIENT_TYPE }}</td>
                                        <td>{{ $row -> ADDRESS }}</td>
                                        <td>{{ $row -> CITY_MUN }}</td>
                                        <td>{{ $row -> CON_PERSON }}</td>
                                        <td>{{ $row -> DESIGNATION }}</td>
                                        <td>{{ $row -> TEL_NO }}</td>
                                        <td>{{ $row -> CELL_NO }}</td>
                                        <td>{{ $row -> EMAIL_ADDR }}</td>
                                        @if($user -> user_authorization == "ADMINISTRATOR" || $user -> user_authorization == 1)
                                            <td class="text-center">
                                                <div class="btn-group-vertical">
                                                    <a type="button" class="btn btn-info" href="{{ route('CustomerController.show', $row->CLIENTID) }}"><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                  </div>
                  <!-- /.col -->
                </div>
              </div>
            </div>
            <!-- /.row -->
          </section>

    </div>
    
@endsection

@section('scripts')
<script>
  $(document).ready(function() {

      $('#customerTable').DataTable({
          "paging":   true,
          "ordering": true,
          "info":     true,
          'searching': true,
      });

      var statusAlert = $('#notifAlert').val();

      if(statusAlert == "1"){
          swal("Customer Information is Successfully Added", "", "success");
      }

  });

</script>
@endsection