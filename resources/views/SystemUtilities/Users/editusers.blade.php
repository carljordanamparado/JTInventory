@extends('main')

@section('content')

     <div class="content-wrapper">

        <section class="content">
            <div class="box">
                @foreach($users as $users)
                 @endforeach
                 <form method="POST" action="{{ route('SystemUsersController.update', $users -> id) }}">
                    <div class="box-body">
                        {{ csrf_field() }}
                        <input name="_method" type="hidden" value="PUT">
                        <div class="row">
                            <div class="form-group col-md-4">
                              <label for=""> Last name </label>
                            <input type="text" class="form-control" id="LastName" name="lname" value="{{ $users -> lastname }}" placeholder="Enter Last Name">
                            </div>
                            <div class="form-group col-md-4">
                              <label for=""> First name </label>
                              <input type="text" class="form-control" id="FirstName" name="fname" value="{{ $users -> firstname }}" placeholder="Enter First Name">
                            </div>
                            <div class="form-group col-md-4">
                              <label for=""> Middle name </label>
                              <input type="text" class="form-control" id="MiddleName" name="mname" value="{{ $users -> middlename }}" placeholder="Enter Middle Name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                              <label for=""> Authorization </label>
                                <select name="auth" class="form-control" id="userLevel">
                                    <option value=""> Choose option</option>

                                    @foreach($user_level as $user_level)
                                        <option value="{{ $user_level->ID }}" {{ $users -> user_authorization == $user_level -> ID ? 'selected="selected" ': '' }}> {{ $user_level -> USER_LEVEL }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                              <label for=""> Designation </label>
                              <input type="text" class="form-control" id="Designation" name="designation" value="{{ $users -> designation }}" placeholder="Enter Designation">
                            </div>
                            <div class="form-group col-md-4">
                              <label for=""> Email Address </label>
                              <input type="email" class="form-control" id="EmailAddress" name="email" value="{{ $users -> email }}" placeholder="Enter Email Address">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                              <label for=""> User ID </label>
                              <input type="text" class="form-control" id="Username" name="userid" value="{{ $users -> userid }}" placeholder="Enter Username" readonly>
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