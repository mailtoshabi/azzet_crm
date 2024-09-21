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

                <li>
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
                        <li><a href="<?php echo e(route('admin.products.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.List_Menu'); ?></a></li>
                    </ul>
                </li>



            </ul>

            
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<?php /**PATH C:\xampp\htdocs\azzet_crm\resources\views/admin/layouts/sidebar.blade.php ENDPATH**/ ?>