<!doctype html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | WBMAHALCRM - Customer Relationship Management Application</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="WBMAHALCRM - Customer Relationship Management Application" name="description" />
    <meta content="WebMahal.com" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}">
    @include('admin.layouts.head-css')
</head>

@section('body')
    @include('admin.layouts.body')
@show
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('admin.layouts.topbar')
        @if (request()->is('employee/*'))
        @include('admin.layouts.employee.sidebar')
        @else
        @include('admin.layouts.sidebar')
        @endif
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
            @include('admin.layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    @include('admin.layouts.right-sidebar')
    <!-- /Right-bar -->

    <!-- JAVASCRIPT -->
    @include('admin.layouts.vendor-scripts')
</body>
<script>
    $(document).ready(function(){
        $('#defaultbranch').on('click', function(e) {
        e.preventDefault();
        // SweetAlert2 popup with input fields
        Swal.fire({
            title: 'Change Branch',
            html:
                '<select id="main_branch_id" name="main_branch_id" class="form-control select2">' +
                                '<option value="">Select Branch</option>' +
                                '@foreach ($mainbranches as $mainbranch)' +
                                '<option value="{{ encrypt($mainbranch->id) }}">{{ $mainbranch->name }}</option>' +
                                '@endforeach' +
                            '</select><br>',
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Submit',
            preConfirm: () => {
                const main_branch_id = document.getElementById('main_branch_id').value;

                // Check if the inputs are valid
                if (!main_branch_id) {
                    Swal.showValidationMessage('Please Select a Branch');
                    return false;
                }
                return { main_branch_id: main_branch_id };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Get input values from the SweetAlert2 popup
                const main_branch_id = result.value.main_branch_id;

                // Send the data using AJAX
                $.ajax({
                    url: '{{ route("admin.branches.makeDefaultGlobal") }}',
                    type: 'POST',
                    data: { main_branch_id: main_branch_id },
                    success: function(response) {
                        Swal.fire(
                            'Success!',
                            'Branch has been changed successfully.',
                            'success'
                        ).then((result) => {
                            refreshPage();
                        });
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'There was a problem with the submission.',
                            'error'
                        );
                    }
                });
            }
        });
        });
    });
</script>
</html>
