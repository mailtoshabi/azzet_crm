<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.Enquiry_List'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('/assets/libs/datatables.net-bs4/datatables.net-bs4.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(URL::asset('assets/libs/datatables.net-responsive-bs4/datatables.net-responsive-bs4.min.css')); ?>" rel="stylesheet" type="text/css" />

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('admin.dir_components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('translation.Proforma_Manage'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('li_2'); ?> <?php echo app('translator')->get('translation.Enquiry_Manage'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> <?php echo app('translator')->get('translation.Enquiry_List'); ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<?php if(session()->has('success')): ?>
<div class="alert alert-success alert-top-border alert-dismissible fade show" role="alert">
    <i class="mdi mdi-check-all me-3 align-middle text-success"></i><strong>Success</strong> - <?php echo e(session()->get('success')); ?>

</div>
<?php endif; ?>
<?php if(session()->has('error')): ?>
<div class="alert alert-danger alert-top-border alert-dismissible fade show" role="alert">
    <i class="mdi mdi-check-all me-3 align-middle text-danger"></i><strong>Error</strong> - <?php echo e(session()->get('error')); ?>

</div>
<?php endif; ?>
<div class="row">
    <div class="col-lg-12">
    <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link <?php if($is_approved==Utility::ITEM_INACTIVE): ?> active <?php endif; ?>" <?php if($is_approved==Utility::ITEM_INACTIVE): ?>aria-current="page"<?php endif; ?> href="<?php echo e(route('admin.enquiries.index','status='.encrypt(Utility::ITEM_INACTIVE))); ?>">Pending <span class="badge rounded-pill bg-soft-danger text-danger float-end"><?php echo e($count_new); ?></span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($is_approved==Utility::ITEM_ACTIVE): ?> active <?php endif; ?>" <?php if($is_approved==Utility::ITEM_ACTIVE): ?>aria-current="page"<?php endif; ?> href="<?php echo e(route('admin.enquiries.index','status='.encrypt(Utility::ITEM_ACTIVE))); ?>">Approved</a>
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
                             <h5 class="card-title"><?php echo app('translator')->get('translation.Enquiry_List'); ?> <span class="text-muted fw-normal ms-2">(<?php echo e($enquiries->count()); ?>)</span></h5>
                         </div>
                     </div>

                     <div class="col-md-6">
                         <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                             
                             <div>
                                 <a href="<?php echo e(route('admin.enquiries.create')); ?>" class="btn btn-light"><i class="bx bx-plus me-1"></i> Add New Enquiry</a>
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
                             <th scope="col"><?php echo app('translator')->get('translation.Customer'); ?></th>
                             <th scope="col">Created By</th>
                             <th scope="col">Items</th>
                             <th scope="col">Notes</th>
                             <th scope="col">Status</th>
                             <th style="width: 80px; min-width: 80px;">Action</th>
                         </tr>
                         </thead>
                         <tbody>
                            <?php $__currentLoopData = $enquiries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enquiry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>
                                    <th scope="row">
                                        <div class="form-check font-size-16">
                                            <input type="checkbox" class="form-check-input" id="contacusercheck1">
                                            <label class="form-check-label" for="contacusercheck1"></label>
                                        </div>
                                    </th>
                                    <td>
                                        <a target="_blank" href="<?php echo e(route('admin.customers.view',encrypt($enquiry->customer->id))); ?>" class=""><?php echo e($enquiry->customer->name); ?></a>
                                    </td>

                                    <td>
                                        <a target="_blank" href="<?php echo e(!empty($enquiry->employee)? route('admin.employees.edit',encrypt($enquiry->employee->id)) :'#'); ?>"><?php echo e(!empty($enquiry->employee)? 'Employee: ' . $enquiry->employee->name : 'Admin: ' . $enquiry->user->name); ?></a>
                                    </td>

                                    <td>
                                        <?php $data = ''; $count = 1;  ?>
                                        <?php $__currentLoopData = $enquiry->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                $comma= $count==1? '':'<br>';
                                                $data .= $comma . '<a target="_blank" href="'. route('admin.products.edit',encrypt($product->id)) . '">' . $product->name . ' (' . $product->pivot->quantity . ')'; $count++; ?>
                                                <?php if(!$product->is_approved): ?>
                                                <?php $data .= ' <span class="badge badge-pill badge-soft-danger font-size-12">Product Not Approved</span>'; ?>
                                                <?php endif; ?>
                                                <?php $data .="</a>" ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <a href="#" class="text-body"><?php echo $data; ?></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-body"><?php echo e($enquiry->description); ?></a>
                                    </td>

                                    <td>
                                        <a> <?php echo $enquiry->estimate?'<span class="badge badge-pill badge-soft-success font-size-12">Estimate Created</span>':'<span class="badge badge-pill badge-soft-danger font-size-12">Estimate Not Created</span>'; ?> </a>
                                    </td>

                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="<?php echo e(route('admin.enquiries.edit',encrypt($enquiry->id))); ?>"><i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit</a></li>
                                                
                                                <li><a href="#" class="dropdown-item" data-plugin="delete-data" data-target-form="#form_delete_<?php echo e($loop->iteration); ?>"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                                <form id="form_delete_<?php echo e($loop->iteration); ?>" method="POST" action="<?php echo e(route('admin.enquiries.destroy',encrypt($enquiry->id))); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="_method" value="DELETE" />
                                                </form>

                                                
                                                <?php if(!$enquiry->estimate): ?>
                                                <li><a class="dropdown-item" href="<?php echo e(route('admin.enquiries.changeStatus',encrypt($enquiry->id))); ?>"><?php echo $enquiry->is_approved?'<i class="fas fa-thumbs-down font-size-16 text-danger me-1"></i> Reject':'<i class="fas fa-thumbs-up font-size-16 text-primary me-1"></i> Approve'; ?></a></li>
                                                <?php endif; ?>
                                                
                                                <?php if(!$enquiry->estimate&&$enquiry->is_approved): ?>
                                                    <li><a class="dropdown-item" href="<?php echo e(route('admin.enquiries.convert_to_estimate',encrypt($enquiry->id))); ?>"><i class="mdi mdi-cursor-pointer font-size-16 text-success me-1"></i> Create Estimate</a></li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                         </tbody>
                     </table>
                     <!-- end table -->
                     <div class="pagination justify-content-center"><?php echo e($enquiries->appends(['status' => encrypt($is_approved)])->links()); ?></div>
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

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\azzet_crm\resources\views/admin/enquiries/index.blade.php ENDPATH**/ ?>