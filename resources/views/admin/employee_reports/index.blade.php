@extends('admin.layouts.master')
@section('title') @lang('translation.EmployeeReport_List') @endsection
@section('css')
<link href="{{ URL::asset('/assets/libs/datatables.net-bs4/datatables.net-bs4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/datatables.net-responsive-bs4/datatables.net-responsive-bs4.min.css') }}" rel="stylesheet" type="text/css" />

@endsection
@section('content')
@component('admin.dir_components.breadcrumb')
@slot('li_1') @lang('translation.Account_Settings') @endslot
@slot('li_2') @lang('translation.Employee_Manage') @endslot
@slot('title') @lang('translation.EmployeeReport_List') @endslot
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
          <a class="nav-link @if($status==Utility::ITEM_ACTIVE) active @endif" @if($status==Utility::ITEM_ACTIVE)aria-current="page"@endif href="{{ route('admin.employee_reports.index','status='.encrypt(Utility::ITEM_ACTIVE)) }}">Recent <span class="badge rounded-pill bg-soft-danger text-danger float-end">{{ $count_new }}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if($status==Utility::ITEM_INACTIVE) active @endif" @if($status==Utility::ITEM_INACTIVE)aria-current="page"@endif href="{{ route('admin.employee_reports.index','status='.encrypt(Utility::ITEM_INACTIVE)) }}">History</a>
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
                             <h5 class="card-title">@lang('translation.EmployeeReport_List') <span class="text-muted fw-normal ms-2">({{ $employee_reports->count() }})</span></h5>
                         </div>
                     </div>
                     <div class="col-md-6">
                        <div class="mb-3">
                            <form method="GET" action="{{ route('admin.employee_reports.index') }}" class="row gx-3 gy-2 align-items-center">
                                {{-- <div class="col-sm-2">
                                    <label class="visually-hidden" for="specificSizeInputName">Name</label>
                                    <input type="text" class="form-control" id="specificSizeInputName" placeholder="Enter Name">
                                </div> --}}
                                <div class="col-md-6">
                                    {{-- <label class="visually-hidden" for="specificSizeInputGroupUsername">Username</label> --}}
                                    <input type="hidden" id="status" name="status" value="{{ encrypt($status) }}">
                                    <select id="employee_id" name="employee_id" class="form-control select2" >
                                        <option value="">Select Employee</option>
                                        @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}" @if(request()->has('employee_id')&&(request('employee_id')==$employee->id)) selected @endif >{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Search Report</button>
                                </div>
                            </form>
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
                             <th scope="col">Employee</th>

                             <th scope="col">Report</th>
                             {{-- @if($status==Utility::ITEM_ACTIVE)
                             <th style="width: 80px; min-width: 80px;">Action</th>
                             @endif --}}
                         </tr>
                         </thead>
                         <tbody>
                            @foreach ($employee_reports as $employee_report)

                                <tr>
                                    <th scope="row">
                                        {{-- <div class="form-check font-size-16">
                                            <input type="checkbox" class="form-check-input" id="contacusercheck1">
                                            <label class="form-check-label" for="contacusercheck1"></label>
                                        </div> --}}
                                    </th>
                                    <td>
                                        <a href="#" class="text-body">{{ $employee_report->reported_at->format('d M, Y') }}</a>
                                    </td>
                                    <td>
                                        <a href="#" class="text-body">{{ $employee_report->employee->name . ' ' . $employee_report->employee->city }}</a>
                                    </td>


                                    <td>
                                        <a href="#" class="text-body">{{ $employee_report->description }}</a>
                                    </td>
                                    {{-- @if($status==Utility::ITEM_ACTIVE)
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="{{ route('employee.employee_reports.edit',encrypt($employee_report->id))}}"><i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit</a></li>
                                                <li><a href="#" class="dropdown-item" data-plugin="delete-data" data-target-form="#form_delete_{{ $loop->iteration }}"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                                <form id="form_delete_{{ $loop->iteration }}" method="POST" action="{{ route('employee.employee_reports.destroy',encrypt($employee_report->id))}}">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="DELETE" />
                                                </form>
                                            </ul>
                                        </div>
                                    </td>
                                    @endif --}}
                                </tr>
                             @endforeach

                         </tbody>
                     </table>
                     <!-- end table -->
                     <div class="pagination justify-content-center">{{ $employee_reports->links() }}</div>
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