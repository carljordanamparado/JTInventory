<!DOCTYPE html>
<html>
    
    @include('partials._head')

    <body class="hold-transition sidebar-mini layout-fixed">
        
        @include('partials._nav')

        <div class="wrapper">

            @yield('content')

        </div>

        @include('partials._javascript')
        @yield('scripts')

    </body>

</html>