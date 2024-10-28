<!doctype html >
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8" />
    <title> <?php echo $__env->yieldContent('title'); ?> | WBMAHALCRM - Customer Relationship Management Application</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="WBMAHALCRM - Customer Relationship Management Application" name="description" />
    <meta content="WebMahal.com" name="author" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo e(URL::asset('assets/images/favicon.ico')); ?>">
    <?php echo $__env->make('admin.layouts.head-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<?php $__env->startSection('body'); ?>
    <?php echo $__env->make('admin.layouts.body', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldSection(); ?>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <?php echo $__env->make('admin.layouts.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php if(request()->is('executive/*')): ?>
        <?php echo $__env->make('admin.layouts.executive.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php else: ?>
        <?php echo $__env->make('admin.layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <?php echo $__env->make('admin.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    <?php echo $__env->make('admin.layouts.right-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- /Right-bar -->

    <!-- JAVASCRIPT -->
    <?php echo $__env->make('admin.layouts.vendor-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                                '<?php $__currentLoopData = $mainbranches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainbranch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>' +
                                '<option value="<?php echo e(encrypt($mainbranch->id)); ?>"><?php echo e($mainbranch->name); ?></option>' +
                                '<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>' +
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
                    url: '<?php echo e(route("admin.branches.makeDefaultGlobal")); ?>',
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
<?php /**PATH C:\xampp\htdocs\azzet_crm\resources\views\admin\layouts\master.blade.php ENDPATH**/ ?>