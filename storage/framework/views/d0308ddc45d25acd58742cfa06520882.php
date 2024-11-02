<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('translation.Add_Enquiry'); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('assets/libs/select2/select2.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(URL::asset('assets/libs/dropzone/dropzone.min.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('admin.dir_components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('translation.Catalogue_Manage'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('li_2'); ?> <?php echo app('translator')->get('translation.Enquiry_Manage'); ?> <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> <?php if(isset($enquiry)): ?> <?php echo app('translator')->get('translation.Edit_Enquiry'); ?> <?php else: ?> <?php echo app('translator')->get('translation.Add_Enquiry'); ?> <?php endif; ?> <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<div class="row">
    <form method="POST" action="<?php echo e(isset($enquiry)? route('employee.enquiries.update') : route('employee.enquiries.store')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php if(isset($enquiry)): ?>
            <input type="hidden" name="enquiry_id" value="<?php echo e(encrypt($enquiry->id)); ?>" />
            <input type="hidden" name="_method" value="PUT" />
        <?php endif; ?>

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Enquiry Details</h4>
                    <p class="card-title-desc"><?php echo e(isset($enquiry)? 'Edit' : "Enter"); ?> the Details of Enquiries</p>
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="control-label"><?php echo app('translator')->get('translation.Customer'); ?></label>
                                    <select id="customer_id" name="customer_id" class="form-control select2">
                                        <option value="">Select <?php echo app('translator')->get('translation.Customer'); ?></option>
                                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($customer->id); ?>" <?php if(isset($enquiry)): ?> <?php echo e($customer->id==$enquiry->customer->id ? 'selected':''); ?> <?php endif; ?>><?php echo e($customer->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['customer_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-danger"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <p><a href="<?php echo e(route('employee.customers.create')); ?>"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;New <?php echo app('translator')->get('translation.Customer'); ?></a></p>
                            </div>

                        </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Products</h4>
                    <p class="card-title-desc"><?php echo e(isset($enquiry)? 'Edit' : "Add"); ?> details of Products</p>
                </div>
                <div class="card-body" id="product_container">
                    <?php if(isset($enquiry)): ?>
                        <?php $__currentLoopData = $enquiry->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $enquiry_product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="row close_container" id="close_container_<?php echo e($index); ?>">

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="control-label">Product</label>
                                        <select id="products-<?php echo e($index); ?>" name="products[<?php echo e($index); ?>]" class="form-control select2">
                                            <option value="">Select Product</option>
                                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($product->id); ?>" <?php echo e($product->id==$enquiry_product->id ? 'selected':''); ?>><?php echo e($product->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="mb-3">
                                        <label>Quantity</label>
                                        <input id="quantities-<?php echo e($index); ?>" name="quantities[<?php echo e($index); ?>]" type="text" class="form-control"  placeholder="Quantity" value="<?php echo e($enquiry_product->pivot->quantity); ?>">
                                    </div>
                                </div>
                                <a class="btn-close" data-target="#close_container_<?php echo e($index); ?>"><i class="fa fa-trash"></i></a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php endif; ?>
                    <?php if(empty($enquiry)): ?>
                        <div class="row">


                            <div class="col-sm-6">

                                <div class="mb-3">
                                    <label class="control-label">Product</label>
                                    <select id="products-0" name="products[0]" class="form-control select2" >
                                        <option value="">Select Product</option>
                                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($product->id); ?>"><?php echo e($product->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="mb-3">
                                    <label>Quantity</label>
                                    <input id="quantities-0" name="quantities[0]" type="text" class="form-control"  placeholder="Quantity" value="">
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="p-4 pt-1">
                    <a href="#" data-toggle="add-more" data-template="#template_product"
                    data-close=".wb-close" data-container="#product_container"
                    data-count="<?php echo e(isset($enquiry) ? $enquiry->products->count()-1 : 0); ?>"
                    data-addindex='[{"selector":".products","attr":"name", "value":"products"},{"selector":".quantities","attr":"name", "value":"quantities"}]'
                    data-plugins='[{"selector":".products","plugin":"select2"}]'
                    data-increment='[{"selector":".products","attr":"id", "value":"products"},{"selector":".quantities","attr":"id", "value":"quantities"}]'><i
                                class="fa fa-plus-circle"></i>&nbsp;&nbsp;Add Item</a>
                </div>
            </div>


            <div class="row hidden" id="template_product">

                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="control-label">Product</label>
                        <select id="" name="" class="form-control products">
                            <option value="">Select Product</option>
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($product->id); ?>"><?php echo e($product->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="mb-3">
                        <label>Quantity</label>
                        <input id="" name="" type="text" class="form-control quantities"  placeholder="Quantity" value="">
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="col-sm-12">
                        <div class="mb-3">
                            <label for="description" class="form-label">Notes</label>
                            <textarea class="form-control" rows="2" placeholder="Enter notes, if any" id="description" name="description"><?php echo e(isset($enquiry)?$enquiry->description:old('description ')); ?></textarea>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light"><?php echo e(isset($enquiry) ? 'Update Enquiry' : 'Save'); ?></button>

                        <button type="reset" class="btn btn-secondary waves-effect waves-light">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <input name="isImageDelete" type="hidden" value="0">
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
        // $('.select2_products').select2();
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
            if(typeof increment == "object") {
                $.each(plugins, function(i, p) {
                if(p.plugin=='select2') {
                    $el.find(p.selector).select2();
                }

            });
            }

            var onchanges = $(this).data("onchanges");
            if(typeof onchanges == "object") {
                $.each(onchanges, function(i, p) {
                    $el.find(p.selector).attr(p.attr, "getcost(this.value," + count + ")");
            });
            }

            $el.hide().appendTo($(this).attr("data-container")).fadeIn();

        });

    })
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.employee.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\azzet_crm\resources\views\admin\employee\enquiries\add.blade.php ENDPATH**/ ?>