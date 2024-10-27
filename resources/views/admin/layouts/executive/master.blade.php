<!doctype html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | Azzet - Customer Relationship Management Application</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}">
    @include('admin.layouts.executive.head-css')
</head>

@section('body')
    @include('admin.layouts.executive.body')
@show
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('admin.layouts.executive.topbar')
        @include('admin.layouts.executive.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('admin.layouts.executive.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    @include('admin.layouts.executive.right-sidebar')
    <!-- /Right-bar -->

    <!-- JAVASCRIPT -->
    @include('admin.layouts.executive.vendor-scripts')
</body>

</html>
