@extends('main')

@section('content')

     <div class="content-wrapper">

        <section class="content">

            <div class="box">
                <div class="box-header">
                  <small> Purchase Order Information </small>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Minimal</label>
                            <select class="form-control" id="custCode">
                              <option selected="selected">Choose Option</option>
                              @foreach($client as $row)
                                  <option value="{{ $row -> CLIENTID }}"> {{ $row -> NAME }} </option>
                              @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">

                        </div>
                        <div class="form-group col-md-4">

                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </section>

    </div>


@endsection

@section('scripts')

    <script type="text/javascript">
        $(document).ready(function() {
          $('#custCode').select2()
        });
    </script>

@endsection