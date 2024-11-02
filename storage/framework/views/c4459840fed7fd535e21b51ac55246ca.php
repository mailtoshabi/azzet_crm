<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.EmployeeReport_List'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('/assets/libs/datatables.net-bs4/datatables.net-bs4.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(URL::asset('assets/libs/datatables.net-responsive-bs4/datatables.net-responsive-bs4.min.css')); ?>" rel="stylesheet" type="text/css" />

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('admin.dir_components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('translation.Account_Settings'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('li_2'); ?> <?php echo app('translator')->get('translation.Employee_Manage'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> <?php echo app('translator')->get('translation.EmployeeReport_List'); ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<?php if(session()->has('success')): ?>
<div class="alert alert-success alert-top-border alert-dismissible fade show" role="alert">
    <i class="mdi mdi-check-all me-3 align-middle text-success"></i><strong>Success</strong> - <?php echo e(session()->get('success')); ?>

</div>
<?php endif; ?>
<div class="row">
    <div class="col-lg-12">
    <ul class="nav nav-tabs">
        
        <li class="nav-item">
          <a class="nav-link <?php if($status==Utility::ITEM_ACTIVE): ?> active <?php endif; ?>" <?php if($status==Utility::ITEM_ACTIVE): ?>aria-current="page"<?php endif; ?> href="<?php echo e(route('employee.employee_reports.index','status='.encrypt(Utility::ITEM_ACTIVE))); ?>">Recent <span class="badge rounded-pill bg-soft-danger text-danger float-end"><?php echo e($count_new); ?></span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($status==Utility::ITEM_INACTIVE): ?> active <?php endif; ?>" <?php if($status==Utility::ITEM_INACTIVE): ?>aria-current="page"<?php endif; ?> href="<?php echo e(route('employee.employee_reports.index','status='.encrypt(Utility::ITEM_INACTIVE))); ?>">History</a>
          </li>
      </ul>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-0">
            <div class="card-body">
                 <div class="row align-items-center">
                     <div class="col-md-6">
                         <div class="mb-3">
                             <h5 class="card-title"><?php echo app('translator')->get('translation.EmployeeReport_List'); ?> <span class="text-muted fw-normal ms-2">(<?php echo e($employee_reports->count()); ?>)</span></h5>
                         </div>
                     </div>

                     <div class="col-md-6">
                         <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                             
                             <div>
                                 <a href="<?php echo e(route('employee.employee_reports.create')); ?>" class="btn btn-light"><i class="bx bx-plus me-1"></i> Add New</a>
                             </div>

                             
                         </div>

                     </div>
                 </div>
                 <!-- end row -->

                 <div class="table-responsive mb-4">
                     <table class="table align-middle dt-responsive table-check nowrap" style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                         <thead>
                         <tr>
                             <th scope="col" style="width: 50px;">
                                 <div class="form-check font-size-16">
                                     <input type="checkbox" class="form-check-input" id="checkAll">
                                     <label class="form-check-label" for="checkAll"></label>
                                 </div>
                             </th>
                             <th scope="col">Date</th>
                             <th scope="col">Report</th>
                             <?php if($status==Utility::ITEM_ACTIVE): ?>
                             <th style="width: 80px; min-width: 80px;">Action</th>
                             <?php endif; ?>
                         </tr>
                         </thead>
                         <tbody>
                            <?php $__currentLoopData = $employee_reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee_report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>
                                    <th scope="row">
                                        
                                    </th>
                                    <td>
                                        <a href="#" class="text-body"><?php echo e($employee_report->reported_at->format('d M, Y')); ?></a>
                                    </td>

                                    <td>
                                        <a href="#" class="text-body"><?php echo e($employee_report->description); ?></a>
                                    </td>
                                    <?php if($status==Utility::ITEM_ACTIVE): ?>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="<?php echo e(route('employee.employee_reports.edit',encrypt($employee_report->id))); ?>"><i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit</a></li>
                                                <li><a href="#" class="dropdown-item" data-plugin="delete-data" data-target-form="#form_delete_<?php echo e($loop->iteration); ?>"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                                <form id="form_delete_<?php echo e($loop->iteration); ?>" method="POST" action="<?php echo e(route('employee.employee_reports.destroy',encrypt($employee_report->id))); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="_method" value="DELETE" />
                                                </form>
                                                
                                            </ul>
                                        </div>
                                    </td>
                                    <?php endif; ?>
                                </tr>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                         </tbody>
                     </table>
                     <!-- end table -->
                     <div class="pagination justify-content-center"><?php echo e($employee_reports->links()); ?></div>
                 </div>
                 <!-- end table responsive -->
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('assets/libs/datatables.net/datatables.net.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/libs/datatables.net-bs4/datatables.net-bs4.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/libs/datatables.net-responsive/datatables.net-responsive.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/pages/datatable-pages.init.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.employee.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\azzet_crm\resources\views/admin/employee/employee_reports/index.blade.php ENDPATH**/ ?>