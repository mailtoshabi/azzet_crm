<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | WBMAHALCRM - Customer Relationship Management Application</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="WBMAHALCRM - Customer Relationship Management Application" name="description" />
    <meta content="WebMahal.com" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}">
    @include('admin.layouts.employee.head-css')
</head>

@section('body')
    @include('admin.layouts.employee.body')
@show

    <!-- Begin page -->
    <div id="layout-wrapper">
 <body data-layout="horizontal">

        @include('admin.layouts.employee.horizontal')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <!-- Start content -->
                <div class="container-fluid">
                    @yield('content')
                </div> <!-- content -->
            </div>
            @include('admin.layouts.employee.footer')
        </div>
        <!-- ============================================================== -->
        <!-- End Right content here -->
        <!-- ============================================================== -->
    </div>
    <!-- END wrapper -->

    <!-- Right Sidebar -->
    @include('admin.layouts.employee.right-sidebar')
    <!-- END Right Sidebar -->

    @include('admin.layouts.employee.vendor-scripts')
</body>

</html>
