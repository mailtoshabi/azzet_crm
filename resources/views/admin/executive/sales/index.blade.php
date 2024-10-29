@extends('admin.layouts.executive.master')
@section('title') @lang('translation.Estimate_List') @endsection
@section('css')
<link href="{{ URL::asset('/assets/libs/datatables.net-bs4/datatables.net-bs4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/datatables.net-responsive-bs4/datatables.net-responsive-bs4.min.css') }}" rel="stylesheet" type="text/css" />

@endsection
@section('content')
@component('admin.dir_components.breadcrumb')
@slot('li_1') @lang('translation.Proforma_Manage') @endslot
@slot('li_2') @lang('translation.Proforma_Invoice') @endslot
@slot('title') @lang('translation.Proforma_List') @endslot
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
          <a class="nav-link @if($status==Utility::STATUS_NEW) active @endif" @if($status==Utility::STATUS_NEW)aria-current="page"@endif href="{{ route('executive.sales.index','status='.encrypt(Utility::STATUS_NEW)) }}">New {!! sales_exe_count(Utility::STATUS_NEW) !!}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if($status==Utility::STATUS_CONFIRMED) active @endif" @if($status==Utility::STATUS_CONFIRMED)aria-current="page"@endif href="{{ route('executive.sales.index','status='.encrypt(Utility::STATUS_CONFIRMED)) }}">Approved {!! sales_exe_count(Utility::STATUS_CONFIRMED) !!}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if($status==Utility::STATUS_PRODUCTION) active @endif" @if($status==Utility::STATUS_PRODUCTION)aria-current="page"@endif href="{{ route('executive.sales.index','status='.encrypt(Utility::STATUS_PRODUCTION)) }}">On Production {!! sales_exe_count(Utility::STATUS_PRODUCTION) !!}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if($status==Utility::STATUS_OUT) active @endif" @if($status==Utility::STATUS_OUT)aria-current="page"@endif href="{{ route('executive.sales.index','status='.encrypt(Utility::STATUS_OUT)) }}">Out for Delivery {!! sales_exe_count(Utility::STATUS_OUT) !!}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if($status==Utility::STATUS_DELIVERED) active @endif" @if($status==Utility::STATUS_DELIVERED)aria-current="page"@endif href="{{ route('executive.sales.index','status='.encrypt(Utility::STATUS_DELIVERED)) }}">Delivered {!! sales_exe_count(Utility::STATUS_DELIVERED) !!}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if($status==Utility::STATUS_ONHOLD) active @endif" @if($status==Utility::STATUS_ONHOLD)aria-current="page"@endif href="{{ route('executive.sales.index','status='.encrypt(Utility::STATUS_ONHOLD)) }}">On Hold {!! sales_exe_count(Utility::STATUS_ONHOLD) !!}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if($status==Utility::STATUS_CANCELLED) active @endif" @if($status==Utility::STATUS_CANCELLED)aria-current="page"@endif href="{{ route('executive.sales.index','status='.encrypt(Utility::STATUS_CANCELLED)) }}">Cancelled</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if($status==Utility::STATUS_CLOSED) active @endif" @if($status==Utility::STATUS_CLOSED)aria-current="page"@endif href="{{ route('executive.sales.index','status='.encrypt(Utility::STATUS_CLOSED)) }}">Closed</a>
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
                             <h5 class="card-title">Proforma Invoices <span class="text-muted fw-normal ms-2">({{ $sales->count() }})</span></h5>
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
                             <th scope="col">Date</th>
                             <th scope="col">Customer</th>
                             <th scope="col">Items</th>
                             <th style="width: 80px; min-width: 80px;">View</th>
                         </tr>
                         </thead>
                         <tbody>
                            @foreach ($sales as $sale)

                                <tr>
                                    <th scope="row">
                                        <div class="form-check font-size-16">
                                            <input type="checkbox" class="form-check-input" id="contacusercheck1">
                                            <label class="form-check-label" for="contacusercheck1"></label>
                                        </div>
                                    </th>
                                    <td>{{ $sale->created_at->format('d-m-Y H:i:s') }}</td>
                                    <td>
                                        <a href="#" class="text-body">{{ $sale->estimate->customer->name }}</a>
                                    </td>

                                    <td>
                                        <?php $data = ''; $count = 1;  ?>
                                        @foreach ($sale->products as $product )
                                                <?php
                                                $comma= $count==1? '':', ';
                                                $data .= $comma . $product->name . ' (' . $product->pivot->quantity . ')'; $count++; ?>
                                        @endforeach
                                        <a href="#" class="text-body">{{ $data }}</a>
                                    </td>
                                    <td>
                                        <a target="_blank" title="view" href="{{ route('executive.sales.view',encrypt($sale->id)) }}"><i class="fa fa-eye font-size-16 text-primary me-1"></i></a>
                                    </td>
                                </tr>
                             @endforeach

                         </tbody>
                     </table>
                     <!-- end table -->
                     <div class="pagination justify-content-center">{{ $sales->links() }}</div>
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
