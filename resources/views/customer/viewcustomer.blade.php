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

            <br>

            <div class="col-md-2" role="alert">
                <a href="{{ route('CustomerController.create') }}" class="btn btn-block btn-primary btn-flat addCustomer pull-right"> Add Customer </a>
            </div>
            
            <br>

            <div class="row">
            
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Customer List</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table id="customerTable" class="table table-bordered table-striped">
                    </table>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </section>

    </div>
    
@endsection

@section('scripts')
<script>
  $(document).ready(function() {
        $('#customerTable').DataTable({

        });
  });
</script>
@endsection