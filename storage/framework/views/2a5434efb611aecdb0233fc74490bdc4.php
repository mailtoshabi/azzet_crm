<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

    <head>
        <meta charset="utf-8" />
        <title> <?php echo $__env->yieldContent('title'); ?> | WBMAHALCRM - Customer Relationship Management Application</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <meta content="WBMAHALCRM - Customer Relationship Management Application" name="description" />
        <meta content="WebMahal.com" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo e(URL::asset('assets/images/favicon.ico')); ?>">
        <?php echo $__env->make('admin.layouts.executive.head-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  </head>

    <?php echo $__env->yieldContent('body'); ?>

    <?php echo $__env->yieldContent('content'); ?>

    <?php echo $__env->make('admin.layouts.executive.vendor-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </body>
</html>
<?php /**PATH C:\xampp\htdocs\azzet_crm\resources\views/admin/layouts/executive/master-without-nav.blade.php ENDPATH**/ ?>