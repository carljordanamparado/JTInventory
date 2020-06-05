@extends('main')

@section('content')


    <div class="content-wrapper">
        <section class="content">
            <div class="box">
                <div class="box-header text-center">
                    <div class="col-md-4" role="alert">
                        <br>
                        <a href="{{ route('OfficialReceipt.create') }}" class="btn btn-block btn-primary btn-flat addCustomer pull-right"> Add Official Receipt</a>
                    </div>
                </div>
                <div class="box-body">

                </div>
            </div>
            <!-- /.row -->
        </section>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function(){

        });
    </script>
@endsection