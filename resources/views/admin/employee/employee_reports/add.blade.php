@extends('admin.layouts.employee.master')
@section('title') @lang('translation.Add_EmployeeReport') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('admin.dir_components.breadcrumb')
@slot('li_1') @lang('translation.Account_Settings') @endslot
@slot('li_2') @lang('translation.Employee_Manage') @endslot
@slot('title') @if(isset($employee_report)) @lang('translation.Edit_EmployeeReport') @else @lang('translation.Add_EmployeeReport') @endif @endslot
@endcomponent
<div class="row">
    <form method="POST" action="{{ isset($employee_report)? route('employee.employee_reports.update') : route('employee.employee_reports.store')  }}">
        @csrf
        @if (isset($employee_report))
            <input type="hidden" name="employee_report_id" value="{{ encrypt($employee_report->id) }}" />
            <input type="hidden" name="_method" value="PUT" />
        @endif

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('translation.EmployeeReport_Manage') Details</h4>
                    <p class="card-title-desc">{{ isset($employee_report)? 'Edit' : "Enter" }} the Details of @lang('translation.EmployeeReport_Manage')</p>
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="reported_at">Date</label>
                                    <input id="reported_at" name="reported_at" class="form-control" type="date" value="@if (empty($employee_report)){{ Carbon\Carbon::parse(now())->format('Y-m-d') }}@else{{ Carbon\Carbon::parse($employee_report->reported_at)->format('Y-m-d') }}@endif">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="description">Report</label>
                                    <textarea id="description" name="description" type="text" class="form-control"  placeholder="Report">@if(!empty($employee_report)) {{ $employee_report->description }}@endif</textarea>
                                </div>
                            </div>

                        </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">{{ isset($employee_report) ? 'Update' : 'Save' }}</button>
                        <button type="reset" class="btn btn-secondary waves-effect waves-light">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- end row -->
@endsection
@section('script')
<script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/ecommerce-select2.init.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
