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
            </div>
            <!-- /.row -->
          </section>

    </div>

@endsection

@section('scripts')
@endsection