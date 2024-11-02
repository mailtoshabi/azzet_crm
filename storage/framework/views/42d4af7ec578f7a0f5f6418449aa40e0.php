<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.Employee_List'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('/assets/libs/datatables.net-bs4/datatables.net-bs4.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(URL::asset('assets/libs/datatables.net-responsive-bs4/datatables.net-responsive-bs4.min.css')); ?>" rel="stylesheet" type="text/css" />

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('admin.dir_components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('translation.Account_Manage'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('li_2'); ?> <?php echo app('translator')->get('translation.Employee_Manage'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> <?php echo app('translator')->get('translation.Employee_List'); ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<?php if(session()->has('success')): ?>
<div class="alert alert-success alert-top-border alert-dismissible fade show" role="alert">
    <i class="mdi mdi-check-all me-3 align-middle text-success"></i><strong>Success</strong> - <?php echo e(session()->get('success')); ?>

</div>
<?php endif; ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-0">
            <div class="card-body">
                 <div class="row align-items-center">
                     <div class="col-md-6">
                         <div class="mb-3">
                             <h5 class="card-title"><?php echo app('translator')->get('translation.Employee_List'); ?> <span class="text-muted fw-normal ms-2">(<?php echo e($employees->count()); ?>)</span></h5>
                         </div>
                     </div>

                     <div class="col-md-6">
                         <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">

                             <div>
                                 <a href="<?php echo e(route('admin.employees.create')); ?>" class="btn btn-light"><i class="bx bx-plus me-1"></i> Add New</a>
                             </div>

                             
                         </div>

                     </div>
                 </div>
                 <!-- end row -->

                 <div class="table-responsive mb-4">
                     <table class="table align-middle datatable dt-responsive table-check nowrap" style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                         <thead>
                         <tr>
                             <th scope="col" style="width: 50px;">
                                 <div class="form-check font-size-16">
                                     <input type="checkbox" class="form-check-input" id="checkAll">
                                     <label class="form-check-label" for="checkAll"></label>
                                 </div>
                             </th>
                             <th scope="col">Name</th>
                             <th scope="col">Branch</th>
                             <th scope="col">Email</th>
                             <th scope="col">Phone</th>
                             <th scope="col">Place</th>
                             <th style="width: 80px; min-width: 80px;">Action</th>
                         </tr>
                         </thead>
                         <tbody>
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th scope="row">
                                        <div class="form-check font-size-16">
                                            <input type="checkbox" class="form-check-input" id="contacemployeecheck1">
                                            <label class="form-check-label" for="contacemployeecheck1"></label>
                                        </div>
                                    </th>
                                    <td>
                                        <?php if(!empty($employee->image)): ?>
                                            <img src="<?php echo e(URL::asset('storage/employees/' . $employee->image)); ?>" alt="" class="avatar-sm rounded-circle me-2">
                                        <?php else: ?>
                                        <div class="avatar-sm d-inline-block align-middle me-2">
                                            <div class="avatar-title bg-soft-primary text-primary font-size-20 m-0 rounded-circle">
                                                <i class="bx bxs-employee-circle"></i>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <a href="#" class="text-body"><?php echo e($employee->name); ?> <?php echo e($employee->roles->count()>0? ' | ':''); ?>

                                            <small>
                                                <?php $__currentLoopData = $employee->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php echo e($role->display_name); ?> <?php echo e($loop->iteration!=1 ? ', ':''); ?>

                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </small>
                                            </a>
                                    </td>
                                    <td><?php echo e($employee->branch->name); ?></td>
                                    <td><?php echo e($employee->email); ?></td>
                                    <td><?php echo e($employee->phone); ?></td>
                                    <td><?php echo e($employee->city); ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a href="<?php echo e(route('admin.employees.edit',encrypt($employee->id))); ?>" class="dropdown-item"><i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit</a></li>
                                            
                                            <?php if(Auth::id()!=$employee->id || $employee->id!=Utility::SUPER_ADMIN_ID): ?>
                                                <li><a href="#" class="dropdown-item" data-plugin="delete-data" data-target-form="#form_delete_<?php echo e($loop->iteration); ?>"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                            <?php endif; ?>
                                            <form id="form_delete_<?php echo e($loop->iteration); ?>" method="POST" action="<?php echo e(route('admin.employees.destroy',encrypt($employee->id))); ?>">
                                                <?php echo csrf_field(); ?>
                                                <input type="hidden" name="_method" value="DELETE" />
                                            </form>
                                            <li><a class="dropdown-item" href="<?php echo e(route('admin.employees.changeStatus',encrypt($employee->id))); ?>"><?php echo $employee->status?'<i class="fas fa-power-off font-size-16 text-danger me-1"></i> Unpublish':'<i class="fas fa-circle-notch font-size-16 text-primary me-1"></i> Publish'; ?></a></li>
                                        </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         </tbody>
                     </table>
                     <!-- end table -->
                     <div class="pagination justify-content-center"><?php echo e($employees->links()); ?></div>
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

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\azzet_crm\resources\views/admin/employees/index.blade.php ENDPATH**/ ?>