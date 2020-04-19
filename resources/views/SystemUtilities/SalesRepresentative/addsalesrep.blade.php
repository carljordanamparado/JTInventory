@extends('main')

@section('content')

  <div class="content-wrapper">

   <section class="content">
       <div class="box">
          <div class="box-header text-center">
            <span> Add Sales Representative </span>
          </div>
           <form method="post" action="{{ route('SalesRepController.store') }}">
               <div class="box-body">
                   {{ csrf_field() }}
                   <div class="row">
                       <div class="form-group col-md-3">
                         <label for=""> Nickname </label>
                         <input type="text" class="form-control" id="nickname" name="nickname" placeholder="Enter Nickname">
                       </div>
                       <div class="form-group col-md-3">
                         <label for=""> Last name </label>
                         <input type="text" class="form-control" id="LastName" name="lname" placeholder="Enter Last Name">
                       </div>
                       <div class="form-group col-md-3">
                         <label for=""> First name </label>
                         <input type="text" class="form-control" id="FirstName" name="fname" placeholder="Enter First Name">
                       </div>
                       <div class="form-group col-md-3">
                         <label for=""> Middle name </label>
                         <input type="text" class="form-control" id="MiddleName" name="mname" placeholder="Enter Middle Name">
                       </div>
                   </div>
                   <div class="row">
                       <div class="form-group col-md-4">
                         <label for=""> Address </label>
                         <input type="text" class="form-control" id="Address" name="address" placeholder="Enter Address">
                       </div>
                       <div class="form-group col-md-4">
                         <label for=""> Birthdate </label>
                         <input type="Date" class="form-control" id="Birthdate" name="birthdate" placeholder="Enter birthdate">
                       </div>
                       <div class="form-group col-md-4">
                         <label for=""> Designation </label>
                         <input type="text" class="form-control" id="Designation" name="Designation" placeholder="Enter Designation">
                       </div>
                   </div>
                   <div class="row">
                       <div class="form-group col-md-6">
                         <label for=""> Contact No. </label>
                         <input type="text" class="form-control" id="contNo" name="contNo" placeholder="Enter Contact Number">
                       </div>
                       <div class="form-group col-md-6">
                         <label for=""> Email Address </label>
                         <input type="email" class="form-control" id="emailAdd" name="emailAdd" placeholder="Enter Email Address">
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
