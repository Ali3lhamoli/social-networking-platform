<!DOCTYPE html>
<html lang="en">

@include('web.admin.layouts.head')

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

@include('web.admin.layouts.header')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->
@include('web.admin.layouts.footer')

</div>
<!-- ./wrapper -->
@include('web.admin.layouts.scripts')

</body>
</html>
