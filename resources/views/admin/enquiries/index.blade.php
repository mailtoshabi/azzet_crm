@extends('admin.layouts.master')
@section('title') @lang('translation.Enquiry_List') @endsection
@section('css')
<link href="{{ URL::asset('/assets/libs/datatables.net-bs4/datatables.net-bs4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/datatables.net-responsive-bs4/datatables.net-responsive-bs4.min.css') }}" rel="stylesheet" type="text/css" />

@endsection
@section('content')
@component('admin.dir_components.breadcrumb')
@slot('li_1') @lang('translation.Proforma_Manage') @endslot
@slot('li_2') @lang('translation.Enquiry_Manage') @endslot
@slot('title') @lang('translation.Enquiry_List') @endslot
@endcomponent
@if(session()->has('success'))
<div class="alert alert-success alert-top-border alert-dismissible fade show" role="alert">
    <i class="mdi mdi-check-all me-3 align-middle text-success"></i><strong>Success</strong> - {{ session()->get('success') }}
</div>
@endif
@if(session()->has('error'))
<div class="alert alert-danger alert-top-border alert-dismissible fade show" role="alert">
    <i class="mdi mdi-check-all me-3 align-middle text-danger"></i><strong>Error</strong> - {{ session()->get('error') }}
</div>
@endif
<div class="row">
    <div class="col-lg-12">
    <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link @if($is_approved==0) active @endif" @if($is_approved==0)aria-current="page"@endif href="{{ route('admin.enquiries.index','status='.encrypt(0)) }}">Pending <span class="badge rounded-pill bg-soft-danger text-danger float-end">{{ $count_new }}</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if($is_approved==1) active @endif" @if($is_approved==1)aria-current="page"@endif href="{{ route('admin.enquiries.index','status='.encrypt(1)) }}">Approved</a>
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
                             <h5 class="card-title">@lang('translation.Enquiry_List') <span class="text-muted fw-normal ms-2">({{ $enquiries->count() }})</span></h5>
                         </div>
                     </div>

                     <div class="col-md-6">
                         <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                             {{-- <div>
                                 <ul class="nav nav-pills">
                                     <li class="nav-item">
                                         <a class="nav-link active" href="apps-contacts-list" data-bs-toggle="tooltip" data-bs-placement="top" title="List"><i class="bx bx-list-ul"></i></a>
                                     </li>
                                     <li class="nav-item">
                                         <a class="nav-link" href="apps-contacts-grid" data-bs-toggle="tooltip" data-bs-placement="top" title="Grid"><i class="bx bx-grid-alt"></i></a>
                                     </li>
                                 </ul>
                             </div> --}}
                             <div>
                                 <a href="{{ route('admin.enquiries.create') }}" class="btn btn-light"><i class="bx bx-plus me-1"></i> Add New Enquiry</a>
                             </div>

                             {{-- <div class="dropdown">
                                 <a class="btn btn-link text-muted py-1 font-size-16 shadow-none dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                     <i class="bx bx-dots-horizontal-rounded"></i>
                                 </a>

                                 <ul class="dropdown-menu dropdown-menu-end">
                                     <li><a class="dropdown-item" href="#">Edit</a></li>
                                     <li><a class="dropdown-item" href="#">Delete</a></li>
                                     <li><a class="dropdown-item" href="#">Deactivate</a></li>
                                 </ul>
                             </div> --}}
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
                             <th scope="col">@lang('translation.Customer')</th>
                             <th scope="col">Enquiry By</th>
                             <th scope="col">Items</th>
                             <th scope="col">Status</th>
                             <th style="width: 80px; min-width: 80px;">Action</th>
                         </tr>
                         </thead>
                         <tbody>
                            @foreach ($enquiries as $enquiry)

                                <tr>
                                    <th scope="row">
                                        <div class="form-check font-size-16">
                                            <input type="checkbox" class="form-check-input" id="contacusercheck1">
                                            <label class="form-check-label" for="contacusercheck1"></label>
                                        </div>
                                    </th>
                                    <td>
                                        <a href="#" class="text-body">{{ $enquiry->customer->name }}</a>
                                    </td>

                                    <td>
                                        <a href="#" class="text-body">{{ !empty($enquiry->executive)? 'Executive: ' . $enquiry->executive->name : 'Admin: ' . $enquiry->user->name }}</a>
                                    </td>

                                    <td>
                                        <?php $data = ''; $count = 1;  ?>
                                        @foreach ($enquiry->products as $product )
                                                <?php
                                                $comma= $count==1? '':'<br>';
                                                $data .= $comma . '<a target="_blank" href="'. route('admin.products.edit',encrypt($product->id)) . '">' . $product->name . ' (' . $product->pivot->quantity . ')'; $count++; ?>
                                                @if(!$product->is_approved)
                                                <?php $data .= ' <span class="badge badge-pill badge-soft-danger font-size-12">Product Not Approved</span>'; ?>
                                                @endif
                                                <?php $data .="</a>" ?>
                                        @endforeach
                                        <a href="#" class="text-body">{!! $data !!}</a>
                                    </td>

                                    <td>
                                        <a> {!! $enquiry->estimate?'<span class="badge badge-pill badge-soft-success font-size-12">Estimate Created</span>':'<span class="badge badge-pill badge-soft-danger font-size-12">Estimate Not Created</span>' !!} </a>
                                    </td>

                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="{{ route('admin.enquiries.edit',encrypt($enquiry->id))}}"><i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit</a></li>
                                                {{-- <li><a class="dropdown-item" href="{{ route('admin.enquiries.destroy',encrypt($enquiry->id))}}"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li> --}}
                                                <li><a href="#" class="dropdown-item" data-plugin="delete-data" data-target-form="#form_delete_{{ $loop->iteration }}"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                                <form id="form_delete_{{ $loop->iteration }}" method="POST" action="{{ route('admin.enquiries.destroy',encrypt($enquiry->id))}}">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="DELETE" />
                                                </form>

                                                @if($enquiry->executive)
                                                @if(!$enquiry->estimate)
                                                <li><a class="dropdown-item" href="{{ route('admin.enquiries.changeStatus',encrypt($enquiry->id))}}">{!! $enquiry->is_approved?'<i class="fas fa-thumbs-down font-size-16 text-danger me-1"></i> Reject':'<i class="fas fa-thumbs-up font-size-16 text-primary me-1"></i> Approve' !!}</a></li>
                                                @endif
                                                @endif
                                                @if(!$enquiry->estimate&&$enquiry->is_approved)
                                                    <li><a class="dropdown-item" href="{{ route('admin.enquiries.convert_to_estimate',encrypt($enquiry->id)) }}"><i class="mdi mdi-cursor-pointer font-size-16 text-success me-1"></i> Create Estimate</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                             @endforeach

                         </tbody>
                     </table>
                     <!-- end table -->
                     <div class="pagination justify-content-center">{{ $enquiries->links() }}</div>
                 </div>
                 <!-- end table responsive -->
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
@endsection
