@extends('admin.layouts.master')
@section('title') @lang('translation.Estimate_List') @endsection
@section('css')
<link href="{{ URL::asset('/assets/libs/datatables.net-bs4/datatables.net-bs4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/datatables.net-responsive-bs4/datatables.net-responsive-bs4.min.css') }}" rel="stylesheet" type="text/css" />

@endsection
@section('content')
@component('admin.dir_components.breadcrumb')
@slot('li_1') @lang('translation.Proforma_Manage') @endslot
@slot('li_2') @lang('translation.Estimate_Manage') @endslot
@slot('title') @lang('translation.Estimate_List') @endslot
@endcomponent
@if(session()->has('success'))
<div class="alert alert-success alert-top-border alert-dismissible fade show" role="alert">
    <i class="mdi mdi-check-all me-3 align-middle text-success"></i><strong>Success</strong> - {{ session()->get('success') }}
</div>
@endif
@if(request()->get('success') && (request()->get('success')==1)) <p class="text-success">Proforma Created Successfully <a href="{{ route('admin.sales.index') }}">View Proforma</a></p>@endif
<div class="row">
    <div class="col-lg-12">
    <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link @if($has_proforma==Utility::ITEM_INACTIVE) active @endif" @if($has_proforma==Utility::ITEM_INACTIVE)aria-current="page"@endif href="{{ route('admin.estimates.index','status='.encrypt(Utility::ITEM_INACTIVE)) }}">New <span class="badge rounded-pill bg-soft-danger text-danger float-end">{{ $count_new }}</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link @if($has_proforma==Utility::ITEM_ACTIVE) active @endif" @if($has_proforma==Utility::ITEM_ACTIVE)aria-current="page"@endif href="{{ route('admin.estimates.index','status='.encrypt(Utility::ITEM_ACTIVE)) }}">History</a>
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
                             <h5 class="card-title">@if($has_proforma==0) Estimate Active List @else Estimate History List @endif <span class="text-muted fw-normal ms-2">({{ $estimates->count() }})</span></h5>
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
                                 <a href="{{ route('admin.estimates.create') }}" class="btn btn-light"><i class="bx bx-plus me-1"></i> Add New Estimate</a>
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
                             <th scope="col">ID</th>
                             <th scope="col">@lang('translation.Customer')</th>
                             <th scope="col">Created By</th>
                             <th scope="col">Items</th>
                             <th scope="col">Sub Total</th>
                             {{-- @if((request()->has('status')==false)|| (request()->has('status') && decrypt(request()->get('status'))==0)) --}}
                             <th style="width: 80px; min-width: 80px;">Action</th>
                             {{-- @endif --}}
                         </tr>
                         </thead>
                         <tbody>
                            @foreach ($estimates as $estimate)
                                <tr>
                                    <th scope="row">
                                        <div class="form-check font-size-16">
                                            <input type="checkbox" class="form-check-input" id="contacusercheck1">
                                            <label class="form-check-label" for="contacusercheck1"></label>
                                        </div>
                                    </th>
                                    <td>
                                        <a href="#" class="text-body">{{ $estimate->id }}</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-body">{{ $estimate->customer->name. ' ' . $estimate->customer->city }}</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-body">{{ $estimate->user->name }}<br>{{ $estimate->user->email }}</a>
                                    </td>
                                    <td>
                                        <?php $data = ''; $count = 1;  ?>
                                        @foreach ($estimate->products as $product )
                                                <?php
                                                $comma= $count==1? '':', ';
                                                $data .= $comma . $product->name . ' (' . $product->pivot->quantity . ')'; $count++; ?>
                                        @endforeach
                                        <a href="#" class="text-body">{{ $data }}</a>
                                    </td>

                                    <td>{{ $estimate->sub_total }}</td>

                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="{{ route('admin.estimates.edit',encrypt($estimate->id))}}"><i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit/View</a></li>
                                                {{-- <li><a class="dropdown-item" href="{{ route('admin.estimates.destroy',encrypt($estimate->id))}}"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li> --}}
                                                @if(!$estimate->sale)
                                                <li><a href="#" class="dropdown-item" data-plugin="delete-data" data-target-form="#form_delete_{{ $loop->iteration }}"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                                <form id="form_delete_{{ $loop->iteration }}" method="POST" action="{{ route('admin.estimates.destroy',encrypt($estimate->id))}}">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="DELETE" />
                                                </form>

                                                <li><a class="dropdown-item" data-plugin="convert-profoma" href="{{ route('admin.estimates.convertToProforma',encrypt($estimate->id))}}"><i class="mdi mdi-cursor-pointer font-size-16 text-success me-1"></i> Convert to Proforma</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>

                                </tr>
                             @endforeach

                         </tbody>
                     </table>
                     <!-- end table -->
                     <div class="pagination justify-content-center">{{ $estimates->appends(['status' => encrypt($has_proforma)])->links() }}</div>
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
<script>
    $(document).ready(function() {

        $(document).on('click','[data-plugin="convert-profoma"]',function(e) {
		e.preventDefault();
        if (!confirm('Do you want to create a proforma for this estimate?')) return;
        var url = $(this).attr('href');
        $.ajax({
            type: "GET",
            url: url,
            success: function (data) {
                goLink(data)
            }
        });
	});

    });
</script>
@endsection
