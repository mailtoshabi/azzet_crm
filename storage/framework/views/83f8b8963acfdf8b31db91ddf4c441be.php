<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.Estimate_List'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('/assets/libs/datatables.net-bs4/datatables.net-bs4.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(URL::asset('assets/libs/datatables.net-responsive-bs4/datatables.net-responsive-bs4.min.css')); ?>" rel="stylesheet" type="text/css" />

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('admin.dir_components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('translation.Proforma_Manage'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('li_2'); ?> <?php echo app('translator')->get('translation.Estimate_Manage'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> <?php echo app('translator')->get('translation.Estimate_List'); ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<?php if(session()->has('success')): ?>
<div class="alert alert-success alert-top-border alert-dismissible fade show" role="alert">
    <i class="mdi mdi-check-all me-3 align-middle text-success"></i><strong>Success</strong> - <?php echo e(session()->get('success')); ?>

</div>
<?php endif; ?>
<?php if(request()->get('success') && (request()->get('success')==1)): ?> <p class="text-success">Proforma Created Successfully <a href="<?php echo e(route('admin.sales.index')); ?>">View Proforma</a></p><?php endif; ?>
<div class="row">
    <div class="col-lg-12">
    <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link <?php if($has_proforma==0): ?> active <?php endif; ?>" <?php if($has_proforma==0): ?>aria-current="page"<?php endif; ?> href="<?php echo e(route('admin.estimates.index','status='.encrypt(0))); ?>">New <span class="badge rounded-pill bg-soft-danger text-danger float-end"><?php echo e($count_new); ?></span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($has_proforma==1): ?> active <?php endif; ?>" <?php if($has_proforma==1): ?>aria-current="page"<?php endif; ?> href="<?php echo e(route('admin.estimates.index','status='.encrypt(1))); ?>">History</a>
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
                             <h5 class="card-title"><?php if($has_proforma==0): ?> Estimate Active List <?php else: ?> Estimate History List <?php endif; ?> <span class="text-muted fw-normal ms-2">(<?php echo e($estimates->count()); ?>)</span></h5>
                         </div>
                     </div>

                     <div class="col-md-6">
                         <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                             
                             <div>
                                 <a href="<?php echo e(route('admin.estimates.create')); ?>" class="btn btn-light"><i class="bx bx-plus me-1"></i> Add New Estimate</a>
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
                             <th scope="col">ID</th>
                             <th scope="col"><?php echo app('translator')->get('translation.Customer'); ?></th>
                             <th scope="col">Created By</th>
                             <th scope="col">Items</th>
                             <th scope="col">Sub Total</th>
                             
                             <th style="width: 80px; min-width: 80px;">Action</th>
                             
                         </tr>
                         </thead>
                         <tbody>
                            <?php $__currentLoopData = $estimates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estimate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th scope="row">
                                        <div class="form-check font-size-16">
                                            <input type="checkbox" class="form-check-input" id="contacusercheck1">
                                            <label class="form-check-label" for="contacusercheck1"></label>
                                        </div>
                                    </th>
                                    <td>
                                        <a href="#" class="text-body"><?php echo e($estimate->id); ?></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-body"><?php echo e($estimate->customer->name. ' ' . $estimate->customer->city); ?></a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-body"><?php echo e($estimate->user->name); ?><br><?php echo e($estimate->user->email); ?></a>
                                    </td>
                                    <td>
                                        <?php $data = ''; $count = 1;  ?>
                                        <?php $__currentLoopData = $estimate->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                $comma= $count==1? '':', ';
                                                $data .= $comma . $product->name . ' (' . $product->pivot->quantity . ')'; $count++; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <a href="#" class="text-body"><?php echo e($data); ?></a>
                                    </td>

                                    <td><?php echo e($estimate->sub_total); ?></td>

                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="<?php echo e(route('admin.estimates.edit',encrypt($estimate->id))); ?>"><i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit/View</a></li>
                                                
                                                <?php if(!$estimate->sale): ?>
                                                <li><a href="#" class="dropdown-item" data-plugin="delete-data" data-target-form="#form_delete_<?php echo e($loop->iteration); ?>"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                                <form id="form_delete_<?php echo e($loop->iteration); ?>" method="POST" action="<?php echo e(route('admin.estimates.destroy',encrypt($estimate->id))); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="_method" value="DELETE" />
                                                </form>

                                                <li><a class="dropdown-item" data-plugin="convert-profoma" href="<?php echo e(route('admin.estimates.convertToProforma',encrypt($estimate->id))); ?>"><i class="mdi mdi-cursor-pointer font-size-16 text-success me-1"></i> Convert to Proforma</a></li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </td>

                                </tr>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                         </tbody>
                     </table>
                     <!-- end table -->
                     <div class="pagination justify-content-center"><?php echo e($estimates->links()); ?></div>
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
<script>
    $(document).ready(function() {

        $(document).on('click','[data-plugin="convert-profoma"]',function(e) {
		e.preventDefault();
        if (!confirm('Do you want to create a proforma for this estimate?')) return;
        var url = $(this).attr('href');
        $.ajax({
            type: "GET",
            url: url,
            success: function (data) {
                goLink(data)
            }
        });
	});

    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\azzet_crm\resources\views/admin/estimates/index.blade.php ENDPATH**/ ?>