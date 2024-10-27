<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.Add_Customer'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('assets/libs/select2/select2.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(URL::asset('assets/libs/dropzone/dropzone.min.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('admin.dir_components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('translation.Account_Manage'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('li_2'); ?> <?php echo app('translator')->get('translation.Customer_Manage'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> <?php if(isset($customer)): ?> <?php echo app('translator')->get('translation.Edit_Customer'); ?> <?php else: ?> <?php echo app('translator')->get('translation.Add_Customer'); ?> <?php endif; ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<?php if(isset($customer) && !$customer->is_approved ): ?>
<div class="alert alert-warning alert-top-border alert-dismissible fade show" role="alert">
    <i class="mdi mdi-check-all me-3 align-middle text-warning"></i><strong>Warning</strong> - This <?php echo app('translator')->get('translation.Customer'); ?> is yet to approve !!
</div>
<?php endif; ?>
<div class="row">
    <form method="POST" action="<?php echo e(isset($customer)? route('admin.customers.update') : route('admin.customers.store')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php if(isset($customer)): ?>
            <input type="hidden" name="customer_id" value="<?php echo e(encrypt($customer->id)); ?>" />
            <input type="hidden" name="_method" value="PUT" />
        <?php endif; ?>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?php echo app('translator')->get('translation.Customer'); ?> Details</h4>
                    <p class="card-title-desc  required"><?php echo e(isset($customer)? 'Edit' : "Enter"); ?> the Details of your <?php echo app('translator')->get('translation.Customer'); ?>, Noted with <label></label> are mandatory.</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="control-label">Branch</label>
                                <select id="branch_id" name="branch_id" class="form-control select2">
                                    <option value="">Select Branch</option>
                                    <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($branch->id); ?>" <?php if(isset($customer)): ?> <?php echo e($branch->id==$customer->branch->id ? 'selected':''); ?> <?php endif; ?>><?php echo e($branch->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['branch_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="mb-3 required">
                                <label for="name"><?php echo app('translator')->get('translation.Name'); ?></label>
                                <input id="name" name="name" type="text" class="form-control"  placeholder="<?php echo app('translator')->get('translation.Name'); ?>" value="<?php echo e(isset($customer)?$customer->name:old('name')); ?>">
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="mb-3">
                                <label for="trade_name"><?php echo app('translator')->get('translation.Trade_Name'); ?></label>
                                <input id="trade_name" name="trade_name" type="text" class="form-control"  placeholder="<?php echo app('translator')->get('translation.Trade_Name'); ?>" value="<?php echo e(isset($customer)?$customer->trade_name:old('trade_name')); ?>">
                                <?php $__errorArgs = ['trade_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="mb-3 required">
                                <label for="phone">Phone</label>
                                <input id="phone" name="phone" type="text" class="form-control"  placeholder="Phone" value="<?php echo e(isset($customer)?$customer->phone:old('phone')); ?>">
                                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input id="email" name="email" type="text" class="form-control" placeholder="Email" value="<?php echo e(isset($customer)?$customer->email:old('email')); ?>">
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="mb-3">
                                <label for="address1">Address Line 1</label>
                                <input id="address1" name="address1" type="text" class="form-control"  placeholder="Building Number" value="<?php echo e(isset($customer)?$customer->address1:old('address1')); ?>">
                                
                            </div>



                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="address2">Address Line 2</label>
                                <input id="address2" name="address2" type="text" class="form-control"  placeholder="Street" value="<?php echo e(isset($customer)?$customer->address2:old('address2')); ?>">
                                
                            </div>
                            <div class="mb-3">
                                <label for="address3">Address Line 3</label>
                                <input id="address3" name="address3" type="text" class="form-control"  placeholder="Street" value="<?php echo e(isset($customer)?$customer->address3:old('address3')); ?>">
                                
                            </div>
                            <div class="mb-3 required">
                                <label for="city">City</label>
                                <input id="city" name="city" type="text" class="form-control"  placeholder="City" value="<?php echo e(isset($customer)?$customer->city:old('city')); ?>">
                                
                            </div>
                            <div class="mb-3">
                                <label for="postal_code">Postal Code</label>
                                <input id="postal_code" name="postal_code" type="text" class="form-control"  placeholder="Postal Code" value="<?php echo e(isset($customer)?$customer->postal_code:old('postal_code')); ?>">
                                
                            </div>

                            <div class="mb-3 required">
                                <label class="control-label">State</label>
                                <select id="state_id" name="state_id" class="form-control select2" onChange="getdistrict(this.value,0);">
                                    <option value="">Select State</option>
                                    <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($state->id); ?>" <?php echo e($state->id==Utility::STATE_ID_KERALA ? 'selected':''); ?>><?php echo e($state->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['state_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="mb-3 required">
                                <label class="control-label">District</label>
                                <select name="district_id" id="district-list" class="form-control select2">
                                    <option value="">Select District</option>
                                </select>
                                <?php $__errorArgs = ['district_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label for="website">Website</label>
                                <input id="website" name="website" type="text" class="form-control"  placeholder="Website" value="<?php echo e(isset($customer)?$customer->website:old('website')); ?>">
                                
                            </div>
                        </div>


                        
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Image</h4>
                    <p class="card-title-desc">Upload Image of your <?php echo app('translator')->get('translation.Customer'); ?>, if any</p>
                </div>
                <div class="card-body">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">

                                    <span id="imageContainer" <?php if(isset($customer)&&empty($customer->image)): ?> style="display: none" <?php endif; ?>>
                                        <?php if(isset($customer)&&!empty($customer->image)): ?>
                                            <img src="<?php echo e(URL::asset(App\Models\Branch::DIR_STORAGE . $customer->image)); ?>" alt="" class="avatar-xxl rounded-circle me-2">
                                            <button type="button" class="btn-close" aria-label="Close"></button>
                                        <?php endif; ?>
                                    </span>

                                    <span id="fileContainer" <?php if(isset($customer)&&!empty($customer->image)): ?> style="display: none" <?php endif; ?>>
                                        <input id="image" name="image" type="file" class="form-control"  placeholder="File">
                                        <?php if(isset($customer)&&!empty($customer->image)): ?>
                                            <button type="button" class="btn-close" aria-label="Close"></button>
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                </div>

            </div> <!-- end card-->

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Tax & Banking</h4>
                    <p class="card-title-desc">Add GST & Bank Account Details of your <?php echo app('translator')->get('translation.Customer'); ?></p>
                </div>
                <div class="card-body">

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="control-label">Bank</label>
                                    <select id="bank_id" name="bank_id" class="form-control select2">
                                        <option value="">Select Bank</option>
                                        <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($bank->id); ?>" <?php if(isset($customer) && isset($customer->bank)): ?> <?php echo e($bank->id==$customer->bank->id ? 'selected':''); ?> <?php endif; ?>><?php echo e($bank->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['bank_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="mb-3">
                                    <label for="bank_branch">Bank branch</label>
                                    <input id="bank_branch" name="bank_branch" type="text" class="form-control"  placeholder="Bank branch" value="<?php echo e(isset($customer)?$customer->bank_branch:old('bank_branch')); ?>">
                                    <?php $__errorArgs = ['bank_branch'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label for="account_name">Account Name</label>
                                    <input id="account_name" name="account_name" type="text" class="form-control" placeholder="Account Name" value="<?php echo e(isset($customer)?$customer->account_name:old('account_name')); ?>">
                                    <?php $__errorArgs = ['account_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="mb-3">
                                    <label for="account_number">Account Number</label>
                                    <input id="account_number" name="account_number" type="text" class="form-control" placeholder="Account Number" value="<?php echo e(isset($customer)?$customer->account_number:old('account_number')); ?>">
                                    <?php $__errorArgs = ['account_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label for="ifsc">IFSC Code</label>
                                    <input id="ifsc" name="ifsc" type="text" class="form-control"  placeholder="IFSC Code" value="<?php echo e(isset($customer)?$customer->ifsc:old('ifsc')); ?>">
                                </div>
                            </div>
                            <p></p>
                            <p></p>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label for="gstin">GSTIN Number</label>
                                    <input id="gstin" name="gstin" type="text" class="form-control" placeholder="GSTIN Number" value="<?php echo e(isset($customer)?$customer->gstin:old('gstin')); ?>">
                                    <?php $__errorArgs = ['gstin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label for="cin">CIN Number</label>
                                    <input id="cin" name="cin" type="text" class="form-control" placeholder="CIN Number" value="<?php echo e(isset($customer)?$customer->cin:old('cin')); ?>">
                                    <?php $__errorArgs = ['cin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label for="pan">PAN Number</label>
                                    <input id="pan" name="pan" type="text" class="form-control" placeholder="PAN Number" value="<?php echo e(isset($customer)?$customer->pan:old('pan')); ?>">
                                    <?php $__errorArgs = ['pan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                </div>

            </div> <!-- end card-->

            

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Contact persons</h4>
                    <p class="card-title-desc">Add details of contact person</p>
                </div>
                <div class="card-body" id="contact_persons_container">
                    <?php if(isset($customer)): ?>
                        <?php $__currentLoopData = $customer->contactPersons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $contactPerson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="row close_container" id="close_container_<?php echo e($index); ?>">

                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label>Name</label>
                                        <input id="contact_names-<?php echo e($index); ?>" name="contact_names[<?php echo e($index); ?>]" type="text" class="form-control"  placeholder="Name" value="<?php echo e($contactPerson->name); ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label>Phone</label>
                                        <input id="phones-<?php echo e($index); ?>" name="phones[<?php echo e($index); ?>]" type="text" class="form-control"  placeholder="Phone" value="<?php echo e($contactPerson->phone); ?>">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label>Email</label>
                                        <input id="emails-<?php echo e($index); ?>" name="emails[<?php echo e($index); ?>]" type="text" class="form-control"  placeholder="Email" value="<?php echo e($contactPerson->email); ?>">
                                    </div>
                                </div>
                                <a class="btn-close" data-target="#close_container_<?php echo e($index); ?>"><i class="fa fa-trash"></i></a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php endif; ?>
                    <?php if(empty($customer)): ?>
                        <div class="row">


                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label for="contact_names">Name</label>
                                    <input id="contact_names-0" name="contact_names[0]" type="text" class="form-control"  placeholder="Name" value="">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Phone</label>
                                    <input id="phones-0" name="phones[0]" type="text" class="form-control"  placeholder="Phone" value="">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input id="emails-0" name="emails[0]" type="text" class="form-control"  placeholder="Email" value="">
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="p-4 pt-1">
                    <a href="#" data-toggle="add-more" data-template="#template_contact_persons"
                    data-close=".wb-close" data-container="#contact_persons_container"
                    data-count="<?php echo e(isset($customer) ? $customer->contactPersons->count()-1 : 0); ?>"
                    data-addindex='[{"selector":".contact_names","attr":"name", "value":"contact_names"},{"selector":".phones","attr":"name", "value":"phones"},{"selector":".emails","attr":"name", "value":"emails"}]'
                    
                    data-increment='[{"selector":".contact_names","attr":"id", "value":"contact_names"},{"selector":".phones","attr":"id", "value":"phones"},{"selector":".emails","attr":"id", "value":"emails"}]'><i
                                class="fa fa-plus-circle"></i>&nbsp;&nbsp;New Contact</a>
                </div>
            </div>


            <div class="row hidden" id="template_contact_persons">

                <div class="col-sm-4">
                    <div class="mb-3">
                        <label>Name</label>
                        <input id="" name="" type="text" class="form-control contact_names"  placeholder="Name" value="">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-3">
                        <label>Phone</label>
                        <input id="phones-0" name="" type="text" class="form-control phones"  placeholder="Phone" value="">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mb-3">
                        <label>Email</label>
                        <input id="" name="" type="text" class="form-control emails"  placeholder="Email" value="">
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
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
<script>
    $(document).ready(function() {
        /*X-CSRF-TOKEN*/
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
        <?php if(isset($customer)): ?>
            getdistrict(<?php echo e(Utility::STATE_ID_KERALA); ?>,<?php echo e($customer->district_id); ?>);
        <?php else: ?>
            getdistrict(<?php echo e(Utility::STATE_ID_KERALA); ?>,0);
        <?php endif; ?>
    });
    function getdistrict(val,d_id) {
        var formData = {'s_id' : val, 'd_id':d_id};
        $.ajax({
            type: "POST",
            url: "<?php echo e(route('admin.customers.list.districts')); ?>",
            data:formData,
            success: function(data){
                $("#district-list").html(data);
                console.log(data);
            }
        });
    }
</script>
<script>
    $(document).ready(function() {
        $('#imageContainer').find('button').click(function() {
            $('#imageContainer').hide();
            $('#fileContainer').show();
            $('input[name="isImageDelete"]').val(1);
        })

        $('#fileContainer').find('button').click(function() {
            $('#fileContainer').hide();
            $('#imageContainer').show();
            $('input[name="isImageDelete"]').val(0);
        })
    });
</script>

<script>
    $(document).ready(function() {
        // $('.select2_rent_terms').select2();
        $(document).on("click", 'a[data-toggle="add-more"]', function(e) {
            e.stopPropagation();
            e.preventDefault();
            var $el = $($(this).attr("data-template")).clone();
            $el.removeClass("hidden");
            $el.attr("id", "");

            var count = $(this).data('count');
            count = typeof count == "undefined" ? 0 : count;
            count = count + 1;
            $(this).data('count', count);

            var addindex = $(this).data("addindex");
            if(typeof addindex == "object") {
                $.each(addindex, function(i, p) {
                    var have_child = p.have_child;
                    if(typeof(have_child)  === "undefined") {
                        $el.find(p.selector).attr(p.attr, p.value + '[' + count + ']');
                    }else {
                        $el.find(p.selector).attr(p.attr, p.value +'['+count+']'+'['+have_child+']' );
                    }
                });
            }

            var increment = $(this).data("increment");
            if(typeof increment == "object") {
                $.each(increment, function(i, p) {
                    var have_child = p.have_child;
                    if(typeof(have_child)  === "undefined") {
                        $el.find(p.selector).attr(p.attr, p.value +"-"+count);
                    }else {
                        $el.find(p.selector).attr(p.attr, p.value +"-"+count+"-"+have_child);
                    }
                });
            }

            var plugins = $(this).data("plugins");
            $.each(plugins, function(i, p) {
                if(p.plugin=='select2') {
                    //$el.find(p.selector).select2();
                }

            });

            $el.hide().appendTo($(this).attr("data-container")).fadeIn();

        });

    })
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\azzet_crm\resources\views/admin/customers/add.blade.php ENDPATH**/ ?>