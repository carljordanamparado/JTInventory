@extends('main')

@section('content')

  <div class="content-wrapper">

   <section class="content">
       <div class="box">
          <div class="box-header text-center">
            <span> Edit Sales Representative </span>
          </div>
           @foreach($salesRep as $sales)
           @endforeach

           <form method="POST" action="{{ route('SalesRepController.update', $sales -> ID) }}">
               <div class="box-body">
                   <input name="_method" type="hidden" value="PUT">
                   {{ csrf_field() }}
                   <div class="row">
                       <div class="form-group col-md-3">
                         <label for=""> Nickname </label>
                         <input type="text" class="form-control" id="nickname" name="nickname" value="{{ $sales -> SALESREP_NAME }}" placeholder="Enter Nickname">
                       </div>
                       <div class="form-group col-md-3">
                         <label for=""> Last name </label>
                         <input type="text" class="form-control" id="LastName" name="lname" value="{{ $sales -> LASTNAME }}" placeholder="Enter Last Name">
                       </div>
                       <div class="form-group col-md-3">
                         <label for=""> First name </label>
                         <input type="text" class="form-control" id="FirstName" name="fname" value="{{ $sales ->FIRSTNAME }}" placeholder="Enter First Name">
                       </div>
                       <div class="form-group col-md-3">
                         <label for=""> Middle name </label>
                         <input type="text" class="form-control" id="MiddleName" name="mname" value="{{ $sales ->MIDDLENAME }}" placeholder="Enter Middle Name">
                       </div>
                   </div>
                   <div class="row">
                       <div class="form-group col-md-4">
                         <label for=""> Address </label>
                         <input type="text" class="form-control" id="Address" name="address" value="{{ $sales ->ADDRESS }}" placeholder="Enter Address">
                       </div>
                       <div class="form-group col-md-4">
                         <label for=""> Birthdate </label>
                         <input type="Date" class="form-control" id="Birthdate" name="birthdate" value="{{ $sales ->BIRTH_DATE }}" placeholder="Enter birthdate">
                       </div>
                       <div class="form-group col-md-4">
                         <label for=""> Designation </label>
                         <input type="text" class="form-control" id="Designation" name="Designation" value="{{ $sales ->DESIGNATION }}" placeholder="Enter Designation">
                       </div>
                   </div>
                   <div class="row">
                       <div class="form-group col-md-6">
                         <label for=""> Contact No. </label>
                         <input type="text" class="form-control" id="contNo" name="contNo" value="{{ $sales ->CONTACT_NO }}" placeholder="Enter Contact Number">
                       </div>
                       <div class="form-group col-md-6">
                         <label for=""> Email Address </label>
                         <input type="email" class="form-control" id="emailAdd" name="emailAdd" value="{{ $sales ->EMAIL }}" placeholder="Enter Email Address">
                       </div>
                   </div>
               </div>
               <div class="box-footer">
                   <div class="row">
                       <div class="form-group col-md-4 pull-right">
                       </div>
                           <button type="submit" class="form-control btn btn-primary"> Edit Sales Representative </button>
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
