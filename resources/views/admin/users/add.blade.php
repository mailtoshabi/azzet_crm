@extends('layouts.master')
@section('title') @lang('translation.Add_User') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') @lang('translation.User_Management') @endslot
@slot('title') @lang('translation.Add_User') @endslot
@endcomponent
<div class="row">
    <form method="POST" action="{{ isset($user)? route('admin.users.update') : route('admin.users.store')  }}" enctype="multipart/form-data">
        @csrf
        @if (isset($user))
            <input type="hidden" name="user_id" value="{{ encrypt($user->id) }}" />
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
                                <label for="first_name">First Name</label>
                                <input id="first_name" name="first_name" type="text" class="form-control"  placeholder="First Name" value="{{ isset($user)?$user->first_name:old('first_name')}}">
                                @error('first_name') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="location">Place</label>
                                <input id="location" name="location" type="text" class="form-control" placeholder="Place" value="{{ isset($user)?$user->location:old('location')}}">
                            </div>

                            <div class="mb-3">
                                <label for="phone">Mobile</label>
                                <input id="phone" name="phone" type="text" class="form-control" placeholder="Mobile" value="{{ isset($user)?$user->phone:old('phone')}}">
                            </div>


                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="last_name">Last Name</label>
                                <input id="last_name" name="last_name" type="text" class="form-control"  placeholder="Last Name" value="{{ isset($user)?$user->last_name:old('last_name')}}">
                                @error('last_name') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>


                            <div class="mb-3">
                                <label for="address">Address</label>
                                <textarea class="form-control" id="address" name="address"  rows="5" placeholder="Address">{{ isset($user)?$user->address:old('address')}}</textarea>
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
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input id="email" name="email" type="text" class="form-control" placeholder="Email" value="{{ isset($user)?$user->email:old('email')}}">
                                @error('email') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label for="horizontal-password-input">Password</label>
                                <input type="password" name="password" class="form-control" id="horizontal-password-input" placeholder="Enter Your Password">
                                @error('password') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label for="email">Role</label>
                                <select id="role_id" name="role_id" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach ($roles as $role )
                                        <option value="{{ encrypt($role->id) }}" {{ isset($user)&&($user->roles->contains($role->id))?'selected':''}}>{{ $role->display_name }}</option>
                                    @endforeach
                                </select>
                                @error('role_id') <p class="text-danger">{{ $message }}</p> @enderror
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
