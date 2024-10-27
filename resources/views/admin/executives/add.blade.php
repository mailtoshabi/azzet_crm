@extends('admin.layouts.master')
@section('title') @lang('translation.Add_Executive') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('admin.dir_components.breadcrumb')
@slot('li_1') @lang('translation.Account_Manage') @endslot
@slot('li_2') @lang('translation.Executive_Manage') @endslot
@slot('title') @if(isset($executive)) @lang('translation.Edit_Executive') @else @lang('translation.Add_Executive') @endif @endslot
@endcomponent
<div class="row">
    <form method="POST" action="{{ isset($executive)? route('admin.executives.update') : route('admin.executives.store')  }}" enctype="multipart/form-data">
        @csrf
        @if (isset($executive))
            <input type="hidden" name="executive_id" value="{{ encrypt($executive->id) }}" />
            <input type="hidden" name="_method" value="PUT" />
        @endif
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Basic Information</h4>
                    <p class="card-title-desc">Fill all information below</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="control-label">Branch</label>
                                <select id="branch_id" name="branch_id" class="form-control select2">
                                    <option value="">Select Branch</option>
                                    @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}" @isset($executive) {{ $branch->id==$executive->branch->id ? 'selected':'' }} @endisset>{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                                @error('branch_id') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input id="name" name="name" type="text" class="form-control"  placeholder="Name" value="{{ isset($executive)?$executive->name:old('name')}}">
                                @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="phone">Mobile</label>
                                <input id="phone" name="phone" type="text" class="form-control" placeholder="Mobile" value="{{ isset($executive)?$executive->phone:old('phone')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="city">Place</label>
                                <input id="city" name="city" type="text" class="form-control" placeholder="Place" value="{{ isset($executive)?$executive->city:old('city')}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Login Information</h4>
                    <p class="card-title-desc">Fill all information below</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input id="email" name="email" type="text" class="form-control" placeholder="Email" value="{{ isset($executive)?$executive->email:old('email')}}">
                                @error('email') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="horizontal-password-input">Password</label>
                                <input type="password" name="password" class="form-control" id="horizontal-password-input" placeholder="Enter Your Password">
                                @error('password') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
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
