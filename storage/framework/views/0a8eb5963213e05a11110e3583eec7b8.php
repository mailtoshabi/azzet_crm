<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu"><?php echo app('translator')->get('translation.Menu'); ?></li>

                <li>
                    <a href="<?php echo e(route('admin.dashboard')); ?>">
                        <i data-feather="home"></i>
                        <span class="badge rounded-pill bg-soft-success text-success float-end">9+</span>
                        <span data-key="t-dashboard"><?php echo app('translator')->get('translation.Dashboards'); ?></span>
                    </a>
                </li>

                <li class="menu-title" data-key="t-apps"><?php echo app('translator')->get('translation.Catalogue_Manage'); ?></li>

                <li class="<?php echo e(set_active(['admin.categories.edit','admin.categories.create'])); ?>">
                    <a href="<?php echo e(route('admin.categories.index')); ?>">
                        <i data-feather="mail"></i>
                        <span data-key="t-email"><?php echo app('translator')->get('translation.Category_Manage'); ?></span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="mail"></i>
                        <span data-key="t-email"><?php echo app('translator')->get('translation.Product_Manage'); ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('admin.products.create')); ?>" data-key="t-inbox"><?php echo app('translator')->get('translation.Add_Menu'); ?></a></li>
                        <li class="<?php echo e(set_active('admin.products.edit')); ?>"><a href="<?php echo e(route('admin.products.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.List_Menu'); ?></a></li>
                        
                        <li class="<?php echo e(set_active(['admin.components.create','admin.components.edit'])); ?>"><a href="<?php echo e(route('admin.components.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.Component_List'); ?></a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="mail"></i>
                        <span data-key="t-email"><?php echo app('translator')->get('translation.Customer_Manage'); ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="<?php echo e(set_active(['admin.customers.edit','admin.customers.view'])); ?>"><a href="<?php echo e(route('admin.customers.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.Customer_List'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.customers.create')); ?>" data-key="t-inbox"><?php echo app('translator')->get('translation.Add_Menu'); ?></a></li>

                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="mail"></i>
                        <span data-key="t-email"><?php echo app('translator')->get('translation.Enquiry_Manage'); ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="<?php echo e(set_active(['admin.enquiries.edit','admin.enquiries.view','admin.enquiries.convert_to_estimate'])); ?>"><a href="<?php echo e(route('admin.enquiries.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.Enquiry_List'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.enquiries.create')); ?>" data-key="t-inbox"><?php echo app('translator')->get('translation.Add_Menu'); ?></a></li>

                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="mail"></i>
                        <span data-key="t-email"><?php echo app('translator')->get('translation.Estimate_Manage'); ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="<?php echo e(set_active(['admin.estimates.edit','admin.estimates.view'])); ?>"><a href="<?php echo e(route('admin.estimates.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.Estimate_List'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.estimates.create')); ?>" data-key="t-inbox"><?php echo app('translator')->get('translation.Add_Menu'); ?></a></li>

                    </ul>
                </li>



            </ul>

            
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<?php /**PATH C:\xampp\htdocs\azzet_crm\resources\views\admin\layouts\sidebar.blade.php ENDPATH**/ ?>