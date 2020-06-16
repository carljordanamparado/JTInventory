@extends('main')

@section('content')

     <div class="content-wrapper">
        <section class="content">
            <div class="box">
              <div class="box-header">
                <div class="col-md-2" role="alert">
                  <a href="{{ route('SystemUsersController.create') }}" class="btn btn-block btn-primary btn-flat addCustomer pull-right"> Add Users </a>
              </div>
              </div>
             <div class="box-body">
                <div class="box-body table-responsive">
                        <table id="salesRep" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">User ID</th>
                                    <th class="text-center">Username</th>
                                    <th class="text-center">User Fullname</th>
                                    <th class="text-center">User Designation</th>
                                    <th class="text-center">User Authorization</th>
                                    <th class="text-center">User Email</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($systemUsers as $systemUsers)
                                    <tr class="text-center">
                                        <td>{{ $systemUsers -> id }}</td>
                                        <td>{{ $systemUsers -> userid }}</td>
                                        <td>{{ $systemUsers -> lastname }} , {{ $systemUsers -> firstname }} {{ $systemUsers -> middlename }}</td>
                                        <td>{{ $systemUsers -> designation }}</td>
                                        <td>{{ $systemUsers -> user_authorization }}</td>
                                        <td>{{ $systemUsers -> email }}</td>
                                        <td class="text-center">
                                            <div class="btn-group-vertical">
                                                <a type="button" class="btn btn-info" href=" {{ route('SystemUsersController.show', $systemUsers -> id) }}"><span class="fa fa-pencil">&nbsp;&nbsp;</span>Edit</a>
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
@endsection
