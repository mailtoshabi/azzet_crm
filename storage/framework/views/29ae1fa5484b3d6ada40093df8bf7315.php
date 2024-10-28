<?php $__env->startSection('title'); ?> Details of <?php echo e($customer->name); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('assets/libs/select2/select2.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(URL::asset('assets/libs/dropzone/dropzone.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('admin.dir_components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('translation.Account_Manage'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('li_2'); ?> <?php echo app('translator')->get('translation.Customer_Manage'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> Details of <?php echo e($customer->name); ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">

                    <div class="col-xl-6">
                        <div class="mt-4 mt-xl-3">
                            <a href="javascript: void(0);" class="text-primary">Created on <?php echo e($customer->created_at->format('d-m-Y')); ?></a>
                            <h4 class="mt-1 mb-3"><?php echo e($customer->name); ?></h4>

                            
                            

                            <?php if (! (empty($customer->phone))): ?>
                                <h6 class="text-primary"><i class="fa fa-phone-square font-size-16 align-middle text-primary me-1"></i><?php echo e($customer->phone); ?></h6>
                            <?php endif; ?>
                            <?php if (! (empty($customer->email))): ?>
                            <h6 class="text-success"><i class="fa fa-envelope font-size-16 align-middle text-success me-1"></i><?php echo e($customer->email); ?></h6>
                            <?php endif; ?>
                            <?php if (! (empty($customer->website))): ?>
                            <h6 class="text-danger"><i class="fa fa-globe font-size-16 align-middle text-success me-1"></i><?php echo e($customer->website); ?></h6>
                            <?php endif; ?>
                            
                            <?php if (! (empty($customer->address1))): ?><p class="text-muted mb-0"><?php echo e($customer->address1); ?></p><?php endif; ?>
                            <?php if (! (empty($customer->address2))): ?><p class="text-muted mb-0"><?php echo e($customer->address2); ?></p><?php endif; ?>
                            <?php if (! (empty($customer->address3))): ?><p class="text-muted mb-0"><?php echo e($customer->address3); ?></p><?php endif; ?>
                            <?php if (! (empty($customer->city))): ?>
                            <p class="text-muted mb-0"><?php echo e($customer->city); ?></p>
                            <?php endif; ?>
                            
                            
                            <?php if (! (empty($customer->postal_code))): ?>
                            <p class="text-muted mb-4"><?php echo e($customer->postal_code); ?></p>
                            <?php endif; ?>

                            <?php if (! (empty($customer->executive))): ?>
                            <p class="text-muted mb-0"><b>Executive Name : <?php echo e($customer->executive->name); ?></b><br>
                                
                                <button type="button" id="add_executive" class="btn btn-primary waves-effect waves-light">Change Executive</button><br><br>
                        <?php endif; ?>
                        <?php if(empty($customer->executive)): ?>
                            
                            <button type="button" id="add_executive" class="btn btn-primary waves-effect waves-light">Assign to an Executive</button><br><br>
                        <?php endif; ?>
                            

                            


                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="product-detai-imgs">
                            <div class="row">
                                
                                <div class="col-md-6 offset-md-1 col-sm-9 col-8">
                                    <div class="tab-content" id="v-pills-tabContent">
                                        <div class="tab-pane fade show active" id="product-1" role="tabpanel" aria-labelledby="product-1-tab">
                                            <div>
                                                <img src="https://place-hold.it/800x800?text=<?php echo e($customer->name); ?>&fontsize=40" alt="" class="img-fluid mx-auto d-block">
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="text-center">
                                        
                                        
                                        
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                
                <!-- end Specifications -->
                <?php if($customer->contactPersons->count() != 0): ?>
                    <div class="mt-5">
                        <h5>Contact People</h5>
                        
                        <?php $__currentLoopData = $customer->contactPersons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contactPerson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="mt-4 border p-4">

                                <div class="row">
                                    <div class="col-xl-12 col-md-12">
                                        <div>
                                            <div class="d-flex">
                                                
                                                <img src="https://place-hold.it/100x100?text=<?php echo e(substr($contactPerson->name, 0, 1)); ?>&fontsize=40" alt="" class="avatar-sm rounded-circle">
                                                <div class="flex-1 ms-4">
                                                    <h5 class="mb-2 font-size-15 text-primary"><?php echo e($contactPerson->name); ?></h5>
                                                    <h5 class="text-muted font-size-15"><?php if (! (empty($contactPerson->phone))): ?> <?php echo e($contactPerson->phone); ?><?php endif; ?> <?php if (! (empty($contactPerson->email))): ?> | <?php echo e($contactPerson->email); ?> <?php endif; ?></h5>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-9 col-md-7">
                                        <div>
                                            

                                            
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- end card -->
    </div>
</div>
<!-- end row -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('/assets/js/app.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>
<script>
    $(document).ready(function() {
        /*X-CSRF-TOKEN*/
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
    });
    $(document).ready(function(){
        $('#add_executive').on('click', function() {

        // SweetAlert2 popup with input fields
        Swal.fire({
            title: 'Assign to an Executive',
            html:
                '<select id="executive_id" name="executive_id" class="form-control select2">' +
                                '<option value="">Select Executive</option>' +
                                '<?php $__currentLoopData = $executives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $executive): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>' +
                                '<option value="<?php echo e($executive->id); ?>" <?php if(isset($customer->executive)): ?> <?php echo e($executive->id==$customer->executive->id ? "selected":""); ?> <?php endif; ?>><?php echo e($executive->name); ?></option>' +
                                '<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>' +
                            '</select><br>' +
                '<input type="hidden" id="customer_id" class="form-control" value="<?php echo e(encrypt($customer->id)); ?>">',
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Submit',
            preConfirm: () => {
                const executive_id = document.getElementById('executive_id').value;
                const customer_id = document.getElementById('customer_id').value;

                // Check if the inputs are valid
                if (!executive_id) {
                    Swal.showValidationMessage('Please Select an Executive');
                    return false;
                }
                return { executive_id: executive_id, customer_id: customer_id };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Get input values from the SweetAlert2 popup
                const executive_id = result.value.executive_id;
                const customer_id = result.value.customer_id;

                // Send the data using AJAX
                $.ajax({
                    url: '<?php echo e(route("admin.customers.addExecutive")); ?>',
                    type: 'POST',
                    data: { executive_id: executive_id, customer_id: customer_id },
                    success: function(response) {
                        Swal.fire(
                            'Success!',
                            'Your data has been submitted.',
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\azzet_crm\resources\views/admin/customers/view.blade.php ENDPATH**/ ?>