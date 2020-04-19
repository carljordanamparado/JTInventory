@extends('main')

@section('content')

     <div class="content-wrapper">

        <section class="content">
            <div class="box">
                @foreach($users as $users)
                 @endforeach
                 <form method="POST" action="{{ route('SystemUsersController.update', $users -> ID) }}">
                    <div class="box-body">
                        {{ csrf_field() }}
                        <input name="_method" type="hidden" value="PUT">
                        <div class="row">
                            <div class="form-group col-md-4">
                              <label for=""> Last name </label>
                            <input type="text" class="form-control" id="LastName" name="lname" value="{{ $users -> LASTNAME }}" placeholder="Enter Last Name">
                            </div>
                            <div class="form-group col-md-4">
                              <label for=""> First name </label>
                              <input type="text" class="form-control" id="FirstName" name="fname" value="{{ $users -> FIRSTNAME }}" placeholder="Enter First Name">
                            </div>
                            <div class="form-group col-md-4">
                              <label for=""> Middle name </label>
                              <input type="text" class="form-control" id="MiddleName" name="mname" value="{{ $users -> MIDDLENAME }}" placeholder="Enter Middle Name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                              <label for=""> Authorization </label>
                              <input type="text" class="form-control" id="Authorization" name="auth" value="{{ $users -> USER_AUTHORIZATION }}" placeholder="Enter Authorization">
                            </div>
                            <div class="form-group col-md-4">
                              <label for=""> Designation </label>
                              <input type="text" class="form-control" id="Designation" name="designation" value="{{ $users -> DESIGNATION }}" placeholder="Enter Designation">
                            </div>
                            <div class="form-group col-md-4">
                              <label for=""> Email Address </label>
                              <input type="email" class="form-control" id="EmailAddress" name="email" value="{{ $users -> EMAIL }}" placeholder="Enter Email Address">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                              <label for=""> User ID </label>
                              <input type="text" class="form-control" id="Username" name="userid" value="{{ $users -> USERID }}" placeholder="Enter Username" readonly>
                            </div>
                            <div class="form-group col-md-4">
                              <label for=""> Password </label>
                              <input type="password" class="form-control" id="Password" name="password" placeholder="Enter Password" readonly>
                            </div>
                            <div class="form-group col-md-4">
                              <label for=""> Confirm Password </label>
                              <input type="password" class="form-control" id="ConfPassword" placeholder="Confirm Password" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="form-group col-md-4 pull-right">
                                <button type="submit" class="form-control btn btn-primary"> Edit Users </button>
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
@endsection