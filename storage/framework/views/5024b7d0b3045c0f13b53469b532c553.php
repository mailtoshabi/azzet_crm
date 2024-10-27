<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu"><?php echo app('translator')->get('translation.Menu'); ?></li>

                <li class="<?php echo e(set_active('executive')); ?>">
                    <a href="<?php echo e(route('executive.dashboard')); ?>">
                        <i class="fas fa-home"></i>
                        <span class="badge rounded-pill bg-soft-success text-success float-end">9+</span>
                        <span data-key="t-dashboard"><?php echo app('translator')->get('translation.Dashboards'); ?></span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="fas fa-binoculars"></i>
                        <span data-key="t-email"><?php echo app('translator')->get('translation.Enquiry_Manage'); ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="<?php echo e(set_active(['executive.enquiries.edit','executive.enquiries.view'])); ?>"><a href="<?php echo e(route('executive.enquiries.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.Enquiry_List'); ?></a></li>
                        <li><a href="<?php echo e(route('executive.enquiries.create')); ?>" data-key="t-inbox"><?php echo app('translator')->get('translation.Add_Menu'); ?></a></li>

                    </ul>
                </li>

                <li class="<?php echo e(set_active(['executive.sales.view'])); ?>">
                    <a href="<?php echo e(route('executive.sales.index')); ?>">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span data-key="t-email"><?php echo app('translator')->get('translation.Proforma_Manage'); ?></span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="fas fa-boxes"></i>
                        <span data-key="t-email"><?php echo app('translator')->get('translation.Product_Manage'); ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('executive.products.create')); ?>" data-key="t-inbox"><?php echo app('translator')->get('translation.Add_Menu'); ?></a></li>
                        <li class="<?php echo e(set_active('executive.products.edit')); ?>"><a href="<?php echo e(route('executive.products.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.List_Menu'); ?></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="fas fa-city"></i>
                        <span data-key="t-email"><?php echo app('translator')->get('translation.Customer_Manage'); ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="<?php echo e(set_active(['executive.customers.edit','executive.customers.view'])); ?>"><a href="<?php echo e(route('executive.customers.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.Customer_List'); ?></a></li>
                        <li><a href="<?php echo e(route('executive.customers.create')); ?>" data-key="t-inbox"><?php echo app('translator')->get('translation.Add_Menu'); ?></a></li>

                    </ul>
                </li>

                
            </ul>

            
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<?php /**PATH C:\xampp\htdocs\azzet_crm\resources\views\admin\layouts\executive\sidebar.blade.php ENDPATH**/ ?>