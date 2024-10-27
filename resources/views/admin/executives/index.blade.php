@extends('admin.layouts.master')
@section('title') @lang('translation.Executive_List') @endsection
@section('css')
<link href="{{ URL::asset('/assets/libs/datatables.net-bs4/datatables.net-bs4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/datatables.net-responsive-bs4/datatables.net-responsive-bs4.min.css') }}" rel="stylesheet" type="text/css" />

@endsection
@section('content')
@component('admin.dir_components.breadcrumb')
@slot('li_1') @lang('translation.Account_Manage') @endslot
@slot('li_2') @lang('translation.Executive_Manage') @endslot
@slot('title') @lang('translation.Executive_List') @endslot
@endcomponent
@if(session()->has('success'))
<div class="alert alert-success alert-top-border alert-dismissible fade show" role="alert">
    <i class="mdi mdi-check-all me-3 align-middle text-success"></i><strong>Success</strong> - {{ session()->get('success') }}
</div>
@endif
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-0">
            <div class="card-body">
                 <div class="row align-items-center">
                     <div class="col-md-6">
                         <div class="mb-3">
                             <h5 class="card-title">@lang('translation.Executive_List') <span class="text-muted fw-normal ms-2">({{ $executives->count() }})</span></h5>
                         </div>
                     </div>

                     <div class="col-md-6">
                         <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">

                             <div>
                                 <a href="{{ route('admin.executives.create') }}" class="btn btn-light"><i class="bx bx-plus me-1"></i> Add New</a>
                             </div>

                             {{-- <div class="dropdown">
                                 <a class="btn btn-link text-muted py-1 font-size-16 shadow-none dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                     <i class="bx bx-dots-horizontal-rounded"></i>
                                 </a>

                                 <ul class="dropdown-menu dropdown-menu-end">
                                     <li><a class="dropdown-item" href="#">Action</a></li>
                                     <li><a class="dropdown-item" href="#">Another action</a></li>
                                     <li><a class="dropdown-item" href="#">Something else here</a></li>
                                 </ul>
                             </div> --}}
                         </div>

                     </div>
                 </div>
                 <!-- end row -->

                 <div class="table-responsive mb-4">
                     <table class="table align-middle datatable dt-responsive table-check nowrap" style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                         <thead>
                         <tr>
                             <th scope="col" style="width: 50px;">
                                 <div class="form-check font-size-16">
                                     <input type="checkbox" class="form-check-input" id="checkAll">
                                     <label class="form-check-label" for="checkAll"></label>
                                 </div>
                             </th>
                             <th scope="col">Name</th>
                             <th scope="col">Branch</th>
                             <th scope="col">Email</th>
                             <th scope="col">Phone</th>
                             <th scope="col">Place</th>
                             <th style="width: 80px; min-width: 80px;">Action</th>
                         </tr>
                         </thead>
                         <tbody>
                            @foreach ($executives as $executive)
                                <tr>
                                    <th scope="row">
                                        <div class="form-check font-size-16">
                                            <input type="checkbox" class="form-check-input" id="contacexecutivecheck1">
                                            <label class="form-check-label" for="contacexecutivecheck1"></label>
                                        </div>
                                    </th>
                                    <td>
                                        @if(!empty($executive->image))
                                            <img src="{{ URL::asset('storage/executives/' . $executive->image) }}" alt="" class="avatar-sm rounded-circle me-2">
                                        @else
                                        <div class="avatar-sm d-inline-block align-middle me-2">
                                            <div class="avatar-title bg-soft-primary text-primary font-size-20 m-0 rounded-circle">
                                                <i class="bx bxs-executive-circle"></i>
                                            </div>
                                        </div>
                                        @endif
                                        <a href="#" class="text-body">{{ $executive->name }}</a>
                                    </td>
                                    <td>{{ $executive->branch->name }}</td>
                                    <td>{{ $executive->email }}</td>
                                    <td>{{ $executive->phone }}</td>
                                    <td>{{ $executive->city }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a href="{{ route('admin.executives.edit',encrypt($executive->id))}}" class="dropdown-item"><i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit</a></li>
                                            {{-- <li><a href="{{ route('admin.executives.destroy',encrypt($executive->id))}}" class="dropdown-item"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li> --}}
                                            @if(Auth::id()!=$executive->id || $executive->id!=Utility::SUPER_ADMIN_ID)
                                                <li><a href="#" class="dropdown-item" data-plugin="delete-data" data-target-form="#form_delete_{{ $loop->iteration }}"><i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Delete</a></li>
                                            @endif
                                            <form id="form_delete_{{ $loop->iteration }}" method="POST" action="{{ route('admin.executives.destroy',encrypt($executive->id))}}">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE" />
                                            </form>
                                            <li><a class="dropdown-item" href="{{ route('admin.executives.changeStatus',encrypt($executive->id))}}">{!! $executive->status?'<i class="fas fa-power-off font-size-16 text-danger me-1"></i> Unpublish':'<i class="fas fa-circle-notch font-size-16 text-primary me-1"></i> Publish'!!}</a></li>
                                        </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                         </tbody>
                     </table>
                     <!-- end table -->
                     <div class="pagination justify-content-center">{{ $executives->links() }}</div>
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
