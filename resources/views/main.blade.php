<!DOCTYPE html>
<html>
    
    @include('partials._head')

    <body class="hold-transition skin-blue sidebar-mini">
        
        @include('partials._nav')

        <div class="wrapper">
           @yield('content')
        </div>

        @include('partials._javascript')
        @yield('scripts')

    </body>

</html>