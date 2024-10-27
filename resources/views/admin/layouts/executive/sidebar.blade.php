<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">@lang('translation.Menu')</li>

                <li class="{{ set_active('executive') }}">
                    <a href="{{ route('executive.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <span class="badge rounded-pill bg-soft-success text-success float-end">9+</span>
                        <span data-key="t-dashboard">@lang('translation.Dashboards')</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="fas fa-binoculars"></i>
                        <span data-key="t-email">@lang('translation.Enquiry_Manage')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="{{ set_active(['executive.enquiries.edit','executive.enquiries.view']) }}"><a href="{{ route('executive.enquiries.index') }}" data-key="t-read-email">@lang('translation.Enquiry_List')</a></li>
                        <li><a href="{{ route('executive.enquiries.create') }}" data-key="t-inbox">@lang('translation.Add_Menu')</a></li>

                    </ul>
                </li>

                <li class="{{ set_active(['executive.sales.view']) }}">
                    <a href="{{ route('executive.sales.index') }}">
                        <i class="fas fa-file-invoice-dollar"></i>
                        <span data-key="t-email">@lang('translation.Proforma_Manage')</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="fas fa-boxes"></i>
                        <span data-key="t-email">@lang('translation.Product_Manage')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('executive.products.create') }}" data-key="t-inbox">@lang('translation.Add_Menu')</a></li>
                        <li class="{{ set_active('executive.products.edit') }}"><a href="{{ route('executive.products.index') }}" data-key="t-read-email">@lang('translation.List_Menu')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i class="fas fa-city"></i>
                        <span data-key="t-email">@lang('translation.Customer_Manage')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="{{ set_active(['executive.customers.edit','executive.customers.view']) }}"><a href="{{ route('executive.customers.index') }}" data-key="t-read-email">@lang('translation.Customer_List')</a></li>
                        <li><a href="{{ route('executive.customers.create') }}" data-key="t-inbox">@lang('translation.Add_Menu')</a></li>

                    </ul>
                </li>

                {{-- @if ($user->hasRole(['Administrator', 'Manager']))
                    <li class="menu-title" data-key="t-apps">@lang('translation.Catalogue_Manage')</li>

                    <li class="{{ set_active(['admin.categories.edit','admin.categories.create']) }}">
                        <a href="{{ route('admin.categories.index') }}">
                            <i data-feather="mail"></i>
                            <span data-key="t-email">@lang('translation.Category_Manage')</span>
                        </a>
                    </li>




                @endif
                @if ($user->hasRole(['Administrator', 'Manager', 'HR']))
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="mail"></i>
                            <span data-key="t-email">@lang('translation.Enquiry_Manage')</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li class="{{ set_active(['admin.enquiries.edit','admin.enquiries.view','admin.enquiries.convert_to_estimate']) }}"><a href="{{ route('admin.enquiries.index') }}" data-key="t-read-email">@lang('translation.Enquiry_List')</a></li>
                            <li><a href="{{ route('admin.enquiries.create') }}" data-key="t-inbox">@lang('translation.Add_Menu')</a></li>

                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="mail"></i>
                            <span data-key="t-email">@lang('translation.Estimate_Manage')</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li class="{{ set_active(['admin.estimates.edit','admin.estimates.view']) }}"><a href="{{ route('admin.estimates.index') }}" data-key="t-read-email">@lang('translation.Estimate_List')</a></li>
                            <li><a href="{{ route('admin.estimates.create') }}" data-key="t-inbox">@lang('translation.Add_Menu')</a></li>

                        </ul>
                    </li>
                @endif
                @if ($user->hasRole('Administrator'))
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="users"></i>
                            <span data-key="t-contacts">@lang('translation.User_Management')</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li class="{{ set_active('admin.users.edit') }}"><a href="{{ route('admin.users.index') }}" data-key="t-user-grid">@lang('translation.UserList')</a></li>
                            <li><a href="{{ route('admin.users.create') }}" data-key="t-user-grid">@lang('translation.Add_User')</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="users"></i>
                            <span data-key="t-contacts">@lang('translation.Role_Management')</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li class="{{ set_active('admin.roles.edit') }}"><a href="{{ route('admin.roles.index') }}" data-key="t-read-email">@lang('translation.Role_List')</a></li>
                            <li><a href="{{ route('admin.roles.create') }}" data-key="t-read-email">@lang('translation.Add_Role')</a></li>
                        </ul>
                    </li>
                @endif --}}
            </ul>

            {{-- <div class="card sidebar-alert shadow-none text-center mx-4 mb-0 mt-5">
                <div class="card-body">
                    <img src="assets/images/giftbox.png" alt="">
                    <div class="mt-4">
                        <h5 class="alertcard-title font-size-16">Unlimited Access</h5>
                        <p class="font-size-13">Upgrade your plan from a Free trial, to select ‘Business Plan’.</p>
                        <a href="#!" class="btn btn-primary mt-2">Upgrade Now</a>
                    </div>
                </div>
            </div> --}}
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
