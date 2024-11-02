<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.Add_EmployeeReport'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('assets/libs/select2/select2.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(URL::asset('assets/libs/dropzone/dropzone.min.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('admin.dir_components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('translation.Account_Settings'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('li_2'); ?> <?php echo app('translator')->get('translation.Employee_Manage'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> <?php if(isset($employee_report)): ?> <?php echo app('translator')->get('translation.Edit_EmployeeReport'); ?> <?php else: ?> <?php echo app('translator')->get('translation.Add_EmployeeReport'); ?> <?php endif; ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<div class="row">
    <form method="POST" action="<?php echo e(isset($employee_report)? route('employee.employee_reports.update') : route('employee.employee_reports.store')); ?>">
        <?php echo csrf_field(); ?>
        <?php if(isset($employee_report)): ?>
            <input type="hidden" name="employee_report_id" value="<?php echo e(encrypt($employee_report->id)); ?>" />
            <input type="hidden" name="_method" value="PUT" />
        <?php endif; ?>

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?php echo app('translator')->get('translation.EmployeeReport_Manage'); ?> Details</h4>
                    <p class="card-title-desc"><?php echo e(isset($employee_report)? 'Edit' : "Enter"); ?> the Details of <?php echo app('translator')->get('translation.EmployeeReport_Manage'); ?></p>
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="reported_at">Date</label>
                                    <input id="reported_at" name="reported_at" class="form-control" type="date" value="<?php if(empty($employee_report)): ?><?php echo e(Carbon\Carbon::parse(now())->format('Y-m-d')); ?><?php else: ?><?php echo e(Carbon\Carbon::parse($employee_report->reported_at)->format('Y-m-d')); ?><?php endif; ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="description">Report</label>
                                    <textarea id="description" name="description" type="text" class="form-control"  placeholder="Report"><?php if(!empty($employee_report)): ?> <?php echo e($employee_report->description); ?><?php endif; ?></textarea>
                                </div>
                            </div>

                        </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light"><?php echo e(isset($employee_report) ? 'Update' : 'Save'); ?></button>
                        <button type="reset" class="btn btn-secondary waves-effect waves-light">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- end row -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('assets/libs/select2/select2.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/libs/dropzone/dropzone.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/pages/ecommerce-select2.init.js')); ?>"></script>
<script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.employee.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\azzet_crm\resources\views\admin\employee\employee_reports\add.blade.php ENDPATH**/ ?>