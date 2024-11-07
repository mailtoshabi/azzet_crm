<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                

                <li class="<?php echo e(set_active('admin')); ?>">
                    <a href="<?php echo e(route('admin.dashboard')); ?>">
                        <i class="fas fa-home"></i>
                        
                        <span data-key="t-dashboard"><?php echo app('translator')->get('translation.Dashboards'); ?></span>
                    </a>
                </li>
                <li class="menu-title" data-key="t-apps"><?php echo app('translator')->get('translation.Proforma_Manage'); ?></li>
                <?php if($user->hasRole(['Administrator', 'Manager', 'HR'])): ?>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i class="fas fa-binoculars"></i>
                            <span data-key="t-email"><?php echo app('translator')->get('translation.Enquiry_Manage'); ?></span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li class="<?php echo e(set_active(['admin.enquiries.edit','admin.enquiries.view','admin.enquiries.convert_to_estimate'])); ?>"><a href="<?php echo e(route('admin.enquiries.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.List_Menu'); ?></a></li>
                            <li><a href="<?php echo e(route('admin.enquiries.create')); ?>" data-key="t-inbox"><?php echo app('translator')->get('translation.Add_Menu'); ?></a></li>

                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i class="fas fa-clipboard"></i>
                            <span data-key="t-email"><?php echo app('translator')->get('translation.Estimate_Manage'); ?></span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li class="<?php echo e(set_active(['admin.estimates.edit','admin.estimates.view'])); ?>"><a href="<?php echo e(route('admin.estimates.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.List_Menu'); ?></a></li>
                            <li><a href="<?php echo e(route('admin.estimates.create')); ?>" data-key="t-inbox"><?php echo app('translator')->get('translation.Add_Menu'); ?></a></li>

                        </ul>
                    </li>

                    <li class="<?php echo e(set_active(['admin.sales.view'])); ?>">
                        <a href="<?php echo e(route('admin.sales.index')); ?>">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span data-key="t-email"><?php echo app('translator')->get('translation.Proforma_Manage'); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if($user->hasRole(['Administrator', 'Manager'])): ?>
                    <li class="menu-title" data-key="t-apps"><?php echo app('translator')->get('translation.Catalogue_Manage'); ?></li>

                    <li class="<?php echo e(set_active(['admin.categories.edit','admin.categories.create'])); ?>">
                        <a href="<?php echo e(route('admin.categories.index')); ?>">
                            <i class="fas fa-coins"></i>
                            <span data-key="t-email"><?php echo app('translator')->get('translation.Category_Manage'); ?></span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i class="fas fa-boxes"></i>
                            <span data-key="t-email"><?php echo app('translator')->get('translation.Product_Manage'); ?></span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="<?php echo e(route('admin.products.create')); ?>" data-key="t-inbox"><?php echo app('translator')->get('translation.Add_Menu'); ?></a></li>
                            <li class="<?php echo e(set_active('admin.products.edit')); ?>"><a href="<?php echo e(route('admin.products.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.List_Menu'); ?></a></li>
                            
                        </ul>
                    </li>

                <?php endif; ?>
                <?php if($user->hasRole(['Administrator', 'Manager'])): ?>
                    <li class="menu-title" data-key="t-apps"><?php echo app('translator')->get('translation.Account_Manage'); ?></li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i class="fas fa-city"></i>
                            <span data-key="t-email"><?php echo app('translator')->get('translation.Customer_Manage'); ?></span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li class="<?php echo e(set_active(['admin.customers.edit','admin.customers.view'])); ?>"><a href="<?php echo e(route('admin.customers.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.List_Menu'); ?></a></li>
                            <li><a href="<?php echo e(route('admin.customers.create')); ?>" data-key="t-inbox"><?php echo app('translator')->get('translation.Add_Menu'); ?></a></li>

                        </ul>
                    </li>
                <?php endif; ?>
                <?php if($user->hasRole('Administrator')): ?>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i class="fas fa-user-tie"></i>
                            <span data-key="t-email"><?php echo app('translator')->get('translation.Employee_Manage'); ?></span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li ><a href="<?php echo e(route('admin.employee_reports.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.EmployeeReport_Manage'); ?></a></li>
                            <li class="<?php echo e(set_active('admin.employees.edit')); ?>"><a href="<?php echo e(route('admin.employees.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.List_Menu'); ?></a></li>
                            <li><a href="<?php echo e(route('admin.employees.create')); ?>" data-key="t-inbox"><?php echo app('translator')->get('translation.Add_Menu'); ?></a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i class="fas fa-user-friends"></i>
                            <span data-key="t-contacts"><?php echo app('translator')->get('translation.User_Management'); ?></span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li class="<?php echo e(set_active('admin.users.edit')); ?>"><a href="<?php echo e(route('admin.users.index')); ?>" data-key="t-user-grid"><?php echo app('translator')->get('translation.List_Menu'); ?></a></li>
                            <li><a href="<?php echo e(route('admin.users.create')); ?>" data-key="t-user-grid"><?php echo app('translator')->get('translation.Add_Menu'); ?></a></li>
                        </ul>
                    </li>


                <li class="menu-title" data-key="t-apps"><?php echo app('translator')->get('translation.Account_Settings'); ?></li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="fas fa-warehouse"></i>
                        <span data-key="t-email"><?php echo app('translator')->get('translation.Branch_Manage'); ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="<?php echo e(set_active('admin.branches.edit')); ?>"><a href="<?php echo e(route('admin.branches.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.List_Menu'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.branches.create')); ?>" data-key="t-inbox"><?php echo app('translator')->get('translation.Add_Menu'); ?></a></li>
                    </ul>
                </li>

                

                <li class="<?php echo e(set_active(['admin.components.create','admin.components.edit'])); ?>">
                    <a href="<?php echo e(route('admin.components.index')); ?>">
                        <i class="fas fa-vials"></i>
                        <span data-key="t-email"><?php echo app('translator')->get('translation.Component_List'); ?></span>
                    </a>
                </li>
                <li class="<?php echo e(set_active(['admin.uoms.create','admin.uoms.edit'])); ?>">
                    <a href="<?php echo e(route('admin.uoms.index')); ?>">
                        <i class="fas fa-tasks"></i>
                        <span data-key="t-email"><?php echo app('translator')->get('translation.Uom_List'); ?></span>
                    </a>
                </li>
                <li class="<?php echo e(set_active(['admin.hsns.create','admin.hsns.edit'])); ?>">
                    <a href="<?php echo e(route('admin.hsns.index')); ?>">
                        <i class="fas fa-qrcode"></i>
                        <span data-key="t-email"><?php echo app('translator')->get('translation.Hsn_Manage'); ?></span>
                    </a>
                </li>
                <li class="<?php echo e(set_active(['admin.tax_slabs.create','admin.tax_slabs.edit'])); ?>">
                    <a href="<?php echo e(route('admin.tax_slabs.index')); ?>">
                        <i class="fas fa-chess"></i>
                        <span data-key="t-email"><?php echo app('translator')->get('translation.Tax_Manage'); ?></span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="fas fa-cog"></i>
                        <span data-key="t-contacts"><?php echo app('translator')->get('translation.Settings'); ?></span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('admin.settings.index')); ?>" data-key="t-read-email"><?php echo app('translator')->get('translation.General_Settings'); ?></a></li>
                        <li><a href="<?php echo e(route('admin.settings.change.password')); ?>" data-key="t-user-grid"><?php echo app('translator')->get('translation.Change_Password'); ?></a></li>
                    </ul>
                </li>
                <?php endif; ?>

            </ul>

            
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
<?php /**PATH C:\xampp\htdocs\azzet_crm\resources\views\admin\layouts\sidebar.blade.php ENDPATH**/ ?>