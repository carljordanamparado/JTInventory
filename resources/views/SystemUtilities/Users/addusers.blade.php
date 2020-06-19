@extends('main')

@section('content')

     <div class="content-wrapper">

        <section class="content">
            <div class="box">
                <form method="post" action="{{ route('SystemUsersController.store') }}">
                    <div class="box-body">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="form-group col-md-4">
                              <label for=""> Last name </label>
                              <input type="text" class="form-control" id="LastName" name="lname" placeholder="Enter Last Name">
                            </div>
                            <div class="form-group col-md-4">
                              <label for=""> First name </label>
                              <input type="text" class="form-control" id="FirstName" name="fname" placeholder="Enter First Name">
                            </div>
                            <div class="form-group col-md-4">
                              <label for=""> Middle name </label>
                              <input type="text" class="form-control" id="MiddleName" name="mname" placeholder="Enter Middle Name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                              <label for=""> Authorization </label>
                                <select name="auth" class="form-control" id="userLevel">
                                    <option value=""> Choose option</option>
                                    @foreach($user_level as $user_level)
                                        <option value="{{ $user_level->ID }}"> {{ $user_level -> USER_LEVEL }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                              <label for=""> Designation </label>
                              <input type="text" class="form-control" id="Designation" name="designation" placeholder="Enter Designation">
                            </div>
                            <div class="form-group col-md-4">
                              <label for=""> Email Address </label>
                              <input type="email" class="form-control" id="EmailAddress" name="email" placeholder="Enter Email Address">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                              <label for=""> User ID </label>
                              <input type="text" class="form-control" id="Username" name="userid" placeholder="Enter Username">
                            </div>
                            <div class="form-group col-md-4">
                              <label for=""> Password </label>
                              <input type="password" class="form-control" id="Password" name="password" placeholder="Enter Password">
                            </div>
                            <div class="form-group col-md-4">
                              <label for=""> Confirm Password </label>
                              <input type="password" class="form-control" id="ConfPassword" placeholder="Confirm Password">
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="form-group col-md-4 pull-right">
                                <button type="submit" class="form-control btn btn-primary"> Add Users </button>
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