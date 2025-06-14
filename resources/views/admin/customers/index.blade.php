@extends('admin.layouts.master')
@section('title') @lang('translation.Customers') @endsection
@section('css')
<link href="{{ URL::asset('/assets/libs/datatables.net-bs4/datatables.net-bs4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/datatables.net-responsive-bs4/datatables.net-responsive-bs4.min.css') }}" rel="stylesheet" type="text/css" />

@endsection
@section('content')
@component('admin.dir_components.breadcrumb')
@slot('li_1') @lang('translation.Account_Manage') @endslot
@slot('li_2') @lang('translation.Customer_Manage') @endslot
@slot('title') @lang('translation.Customer_List') @endslot
@endcomponent
@if(session()->has('success'))
<div class="alert alert-success alert-top-border alert-dismissible fade show" role="alert">
    <i class="mdi mdi-check-all me-3 align-middle text-success"></i><strong>Success</strong> - {{ session()->get('success') }}
</div>
@endif
<div class="row">
    <div class="col-lg-12">
    <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link @if($is_approved==Utility::ITEM_INACTIVE) active @endif" @if($is_approved==Utility::ITEM_INACTIVE)aria-current="page"@endif href="{{ route('admin.customers.index','status='.encrypt(Utility::ITEM_INACTIVE)) }}">Pending <span class="badge rounded-pill bg-soft-danger text-danger float-end">{{ $count_new }}</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if($is_approved==Utility::ITEM_ACTIVE) active @endif" @if($is_approved==Utility::ITEM_ACTIVE)aria-current="page"@endif href="{{ route('admin.customers.index','status='.encrypt(Utility::ITEM_ACTIVE)) }}">Approved</a>
        </li>
      </ul>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-0">
            <div class="card-body">
                <!-- Nav tabs -->
                {{-- <ul class="nav nav-tabs" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link {{ $status==Utility::ITEM_INACTIVE?'active':'' }}" data-plugin="render-tab" data-tab=".customerdetailsTab" href="{{ route('admin.customers.show.tab', encrypt(Utility::ITEM_INACTIVE)) }}" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">Non Verified Customers</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ $status==Utility::ITEM_ACTIVE?'active':'' }}" data-plugin="render-tab" data-tab=".customerdetailsTab" href="{{ route('admin.customers.show.tab', encrypt(Utility::ITEM_ACTIVE)) }}"  role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Verified Customers</span>
                        </a>
                    </li>

                </ul> --}}
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane customerdetailsTab active" role="tabpanel">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="mb-3">
                                <h5 class="card-title">@lang('translation.Customer_List') <span class="text-muted fw-normal ms-2">({{ $customers->total() }})</span></h5>
                                </div>
                            </div>

                            {{-- <div class="col-md-6">
                                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                                    <div>
                                        <a href="{{ route('admin.customers.create') }}" class="btn btn-light"><i class="bx bx-plus me-1"></i> Add New</a>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                         <!-- end row -->

                        <div class="table-responsive mb-4">
                            <table class="table align-middle dt-responsive table-check nowrap" style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                                <thead>
                                <tr>
                                    {{-- <th scope="col" style="width: 50px;">
                                        <div class="form-check font-size-16">
                                            <input type="checkbox" class="form-check-input" id="checkAll">
                                            <label class="form-check-label" for="checkAll"></label>
                                        </div>
                                    </th> --}}
                                    <th scope="col">Name</th>
                                    <th scope="col">Mobile</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">City</th>
                                    <th scope="col">Created</th>
                                    <th style="width: 80px; min-width: 80px;">View</th>
                                </tr>
                                </thead>
                                <tbody>
                                   @foreach ($customers as $customer)
                                       <tr>
                                           {{-- <th scope="row">
                                               <div class="form-check font-size-16">
                                                   <input type="checkbox" class="form-check-input" id="contacusercheck1">
                                                   <label class="form-check-label" for="contacusercheck1"></label>
                                               </div>
                                           </th> --}}

                                           <td>
                                               @if(!empty($customer->image))
                                                   <img src="{{ URL::asset('storage/customers/' . $customer->image) }}" alt="" class="avatar-sm rounded-circle me-2">
                                               @else
                                               <div class="avatar-sm d-inline-block align-middle me-2">
                                                   <div class="avatar-title bg-soft-primary text-primary font-size-20 m-0 rounded-circle">
                                                       <i class="bx bxs-user-circle"></i>
                                                   </div>
                                               </div>
                                               @endif
                                               <a href="{{ route('admin.customers.edit',encrypt($customer->id)) }}" class="">{{ $customer->name }}</a>
                                            </td>

                                           <td>{{ $customer->phone }}</td>
                                           <td>{{ $customer->email }}</td>
                                           <td>
                                            {{ $customer->city }}
                                            <br> <small>{{ $customer->district->name }} District</small>
                                           </td>
                                           <td>
                                            <a href="#" class="text-body">
                                                On {{ $customer->created_at->format('d M Y') }}<br>
                                                By {{ !empty($customer->employee)? $customer->employee->name . ' (Employee)' : $customer->user->name . ' (Admin)' }}
                                            </a>
                                        </td>
                                           {{-- <td>
                                                <a href="{{ route('admin.customers.view',encrypt($customer->id))}}" class="btn btn-primary btn-sm btn-rounded" >
                                                    Details
                                                </a>
                                            </td> --}}
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="{{ route('admin.customers.edit',encrypt($customer->id))}}"><i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit</a></li>
                                                        {{-- <li><a class="dropdown-item" href="{{ route('admin.customers.destroy',encrypt($customer->id))}}"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li> --}}
                                                        @if(!$customer->is_approved)
                                                        <li><a href="#" class="dropdown-item" data-plugin="delete-data" data-target-form="#form_delete_{{ $loop->iteration }}"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                                        <form id="form_delete_{{ $loop->iteration }}" method="POST" action="{{ route('admin.customers.destroy',encrypt($customer->id))}}">
                                                            @csrf
                                                            <input type="hidden" name="_method" value="DELETE" />
                                                        </form>
                                                        @endif
                                                        @if($customer->employee)
                                                            <li><a class="dropdown-item" href="{{ route('admin.customers.approve',encrypt($customer->id))}}">{!! $customer->is_approved?'<i class="fas fa-thumbs-down font-size-16 text-danger me-1"></i> Reject':'<i class="fas fa-thumbs-up font-size-16 text-primary me-1"></i> Approve' !!}</a></li>
                                                        @endif
                                                        @if($customer->is_approved)
                                                            <li><a class="dropdown-item" href="{{ route('admin.customers.changeStatus',encrypt($customer->id))}}">{!! $customer->status?'<i class="fas fa-power-off font-size-16 text-danger me-1"></i> Unpublish':'<i class="fas fa-circle-notch font-size-16 text-primary me-1"></i> Publish'!!}</a></li>
                                                        @endif
                                                        <li><a class="dropdown-item" href="{{ route('admin.customers.view',encrypt($customer->id))}}"><i class="fa fa-eye font-size-16 text-success me-1"></i> Details</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                       </tr>
                                   @endforeach
                                </tbody>
                            </table>
                            <!-- end table -->
                            <div class="pagination justify-content-center">{{ $customers->appends(['status' => encrypt($is_approved)])->links() }}</div>
                        </div>
                         <!-- end table responsive -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/datatables.net/datatables.net.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-bs4/datatables.net-bs4.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-responsive/datatables.net-responsive.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/datatable-pages.init.js') }}"></script>
{{-- <script>
    $(document).ready(function() {
        $(document).on('click','[data-plugin="render-tab"]',function(e) {
            e.preventDefault();

            $('.nav-link').removeClass('active');
            $(this).addClass('active');
            var url = $(this).data('target');
            var tab_Id = $(this).data('tab');
            renderTab(url,tab_Id);
        });
    });

    var url = "{{ route('admin.customers.show.tab', Utility::ITEM_INACTIVE) }}";
    var tab_Id = ".customerdetailsTab";
    renderTab(url,tab_Id);

    function renderTab(url,tab_Id) {
        $.get(url, function (data) {
            var $el = $(data.html).clone();
            $el = $(tab_Id).html($el);
            $(tab_Id).tab('show');
        });
    }
</script> --}}
@endsection
