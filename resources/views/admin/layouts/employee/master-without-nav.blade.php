<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8" />
        <title> @yield('title') | WBMAHALCRM - Customer Relationship Management Application</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta content="WBMAHALCRM - Customer Relationship Management Application" name="description" />
        <meta content="WebMahal.com" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico')}}">
        @include('admin.layouts.employee.head-css')
  </head>

    @yield('body')

    @yield('content')

    @include('admin.layouts.employee.vendor-scripts')
    </body>
</html>
