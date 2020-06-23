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
        @include('Reports.CustomerReports.Viewing.agingaccount')
        @include('Reports.CustomerReports.Viewing.viewsummary')

        <div class="wrapper">
           @yield('content')
        </div>

        @include('partials._javascript')
        @yield('scripts')

    </body>

    <script>
        $(document).ready(function(){

            $('#custStatement, #agingCust, #summary').select2({
                placeholder: 'Select an option',
                dropdownAutoWidth: true,
                allowClear: true
            });

            $('#statementAccount, #agingAccount , #summaryAccount').on('hidden.bs.modal', function(){
                //$('#statement').clear();
                $('#custStatement, #agingCust').empty().append('<option>Choose Option</option>')
            });

            $('#statementAccount, #agingAccount, #summaryAccount').on('shown.bs.modal', function(){
                $.ajax({
                    url: "{{ route('StatementReport') }}",
                    type: "GET",
                    success: function(response){
                        $('#custStatement, #agingCust , #summary').append(response.option);
                    },
                    error: function(jqXHR){
                        console.log(jqXHR);
                    }

                });
            });

         /*   function submitButton(){

                var id = $('#custDetails option:selected').val();
                var from_date = $('#fromDate').val();
                var to_date = $('#toDate').val();

                $.ajax({
                    url: "{{ route('statement_report') }}",
                    type: "GET",
                    data:{
                        '_token': $('input[name=_token]').val(),
                        'id' : id,
                        'from_date' : from_date,
                        'to_date' : to_date
                    },
                    success: function(response){
                        window.open("{{ route('statement_report') }}", 'Name');
                    },
                    error: function(jqXHR){
                        console.log(jqXHR);
                    }
                });
            }

            $('#reportButton').on('click', function(){
                submitButton();
            });*/

        });
    </script>

</html>