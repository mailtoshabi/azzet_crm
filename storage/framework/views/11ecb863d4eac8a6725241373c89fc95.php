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
          <a class="nav-link <?php if($status==Utility::ITEM_ACTIVE): ?> active <?php endif; ?>" <?php if($status==Utility::ITEM_ACTIVE): ?>aria-current="page"<?php endif; ?> href="<?php echo e(route('admin.employee_reports.index','status='.encrypt(Utility::ITEM_ACTIVE))); ?>">Recent <span class="badge rounded-pill bg-soft-danger text-danger float-end"><?php echo e($count_new); ?></span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($status==Utility::ITEM_INACTIVE): ?> active <?php endif; ?>" <?php if($status==Utility::ITEM_INACTIVE): ?>aria-current="page"<?php endif; ?> href="<?php echo e(route('admin.employee_reports.index','status='.encrypt(Utility::ITEM_INACTIVE))); ?>">History</a>
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
                        <div class="mb-3">
                            <form method="GET" action="<?php echo e(route('admin.employee_reports.index')); ?>" class="row gx-3 gy-2 align-items-center">
                                
                                <div class="col-md-6">
                                    
                                    <input type="hidden" id="status" name="status" value="<?php echo e(encrypt($status)); ?>">
                                    <select id="employee_id" name="employee_id" class="form-control select2" >
                                        <option value="">Select Employee</option>
                                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($employee->id); ?>" <?php if(request()->has('employee_id')&&(request('employee_id')==$employee->id)): ?> selected <?php endif; ?> ><?php echo e($employee->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Search Report</button>
                                </div>
                            </form>
                        </div>
                    </div>
                     <div class="col-md-6">
                         <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                             

                             
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
                             <th scope="col">Employee</th>

                             <th scope="col">Report</th>
                             
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
                                        <a href="#" class="text-body"><?php echo e($employee_report->employee->name . ' ' . $employee_report->employee->city); ?></a>
                                    </td>


                                    <td>
                                        <a href="#" class="text-body"><?php echo e($employee_report->description); ?></a>
                                    </td>
                                    
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

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\azzet_crm\resources\views\admin\employee_reports\index.blade.php ENDPATH**/ ?>