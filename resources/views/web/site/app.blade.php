<!DOCTYPE html>
<html lang="en">
@include('web.site.layouts.head')

<body class="hold-transition sidebar-mini layout-fixed bg-dark text-white">
    <div class="wrapper">
        @stack('style')
        
        @include('web.site.layouts.header')


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->
        @include('web.site.layouts.footer')

    </div>
    <!-- ./wrapper -->
    @stack('scripts')
    @include('web.site.layouts.scripts')

</body>

</html>
