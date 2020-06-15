<!DOCTYPE html>
<html>
    
    @include('partials._head')

    <body class="hold-transition skin-blue sidebar-mini">

        <style>
            .select2 {
                width:100%!important;
                height:100%!important;
            }
        </style>
        
        @include('partials._nav')

        @include('Reports.CustomerReports.Viewing.viewstatement')

        <div class="wrapper">
           @yield('content')
        </div>

        @include('partials._javascript')
        @yield('scripts')

    </body>

    <script>
        $(document).ready(function(){

            $('#custDetails').select2({
                placeholder: 'Select an option',
                dropdownAutoWidth: true,
                allowClear: true
            });

            $('#statementAccount').on('hidden.bs.modal', function(){
                //$('#statement').clear();
                $('#custDetails').empty().append('<option>Choose Option</option>')
            });

            $('#statementAccount').on('shown.bs.modal', function(){
                $.ajax({
                    url: "{{ route('StatementReport') }}",
                    type: "GET",
                    success: function(response){
                        $('#custDetails').append(response.option);
                    },
                    error: function(jqXHR){
                        console.log(jqXHR);
                    }

                });
            });

            function submitButton(){

                var id = $('#custDetails option:selected').val();
                var from_date = $('#fromDate').val();
                var to_date = $('#toDate').val();

                $.ajax({
                    url: "{{ route('statement_report') }}",
                    type: "POST",
                    data:{
                        '_token': $('input[name=_token]').val(),
                        'id' : id,
                        'from_date' : from_date,
                        'to_date' : to_date
                    },
                    success: function(response){

                    },
                    error: function(jqXHR){
                        console.log(jqXHR);
                    }
                });
            }

            /*$('#reportButton').on('click', function(){
               submitButton();
            });*/

        });
    </script>

</html>