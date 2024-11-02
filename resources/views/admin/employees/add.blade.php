@extends('admin.layouts.master')
@section('title') @lang('translation.Add_Employee') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('admin.dir_components.breadcrumb')
@slot('li_1') @lang('translation.Account_Manage') @endslot
@slot('li_2') @lang('translation.Employee_Manage') @endslot
@slot('title') @if(isset($employee)) @lang('translation.Edit_Employee') @else @lang('translation.Add_Employee') @endif @endslot
@endcomponent
<div class="row">
    <form method="POST" action="{{ isset($employee)? route('admin.employees.update') : route('admin.employees.store')  }}" enctype="multipart/form-data">
        @csrf
        @if (isset($employee))
            <input type="hidden" name="employee_id" value="{{ encrypt($employee->id) }}" />
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
                            {{-- <div class="mb-3">
                                <label class="control-label">Branch</label>
                                <select id="branch_id" name="branch_id" class="form-control select2">
                                    <option value="">Select Branch</option>
                                    @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}" @isset($employee) {{ $branch->id==$employee->branch->id ? 'selected':'' }} @endisset>{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                                @error('branch_id') <p class="text-danger">{{ $message }}</p> @enderror
                            </div> --}}
                            <div class="mb-3 required">
                                <label for="name">Name</label>
                                <input id="name" name="name" type="text" class="form-control"  placeholder="Name" value="{{ isset($employee)?$employee->name:old('name')}}">
                                @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-3 required">
                                <label for="city">Place</label>
                                <input id="city" name="city" type="text" class="form-control" placeholder="Place" value="{{ isset($employee)?$employee->city:old('city')}}">
                                @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-3 required">
                                <label for="postal_code">Postal Code</label>
                                <input id="postal_code" name="postal_code" type="text" class="form-control"  placeholder="Postal Code" value="{{ isset($employee)?$employee->postal_code:old('postal_code')}}">
                                @error('postal_code') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3 required">
                                <label class="control-label">State</label>
                                <select id="state_id" name="state_id" class="form-control select2" onChange="getdistrict(this.value,0);">
                                    <option value="">Select State</option>
                                    @foreach ($states as $state)
                                    <option value="{{ $state->id }}" {{ $state->id==Utility::STATE_ID_KERALA ? 'selected':'' }}>{{ $state->name }}</option>
                                    @endforeach
                                </select>
                                @error('state_id') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-3 required">
                                <label class="control-label">District</label>
                                <select name="district_id" id="district-list" class="form-control select2">
                                    <option value="">Select District</option>
                                </select>
                                @error('district_id') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="postal_code">Image</label>
                                <span id="imageContainer" @if(isset($employee)&&empty($employee->image)) style="display: none" @endif>
                                    @if(isset($employee)&&!empty($employee->image))
                                        <img src="{{ URL::asset(App\Models\Branch::DIR_STORAGE . $employee->image) }}" alt="" class="avatar-xxl rounded-circle me-2">
                                        <button type="button" class="btn-close" aria-label="Close"></button>
                                    @endif
                                </span>

                                <span id="fileContainer" @if(isset($employee)&&!empty($employee->image)) style="display: none" @endif>
                                    <input id="avatar" name="avatar" type="file" class="form-control"  placeholder="File">
                                    @if(isset($employee)&&!empty($employee->image))
                                        <button type="button" class="btn-close" aria-label="Close"></button>
                                    @endif
                                </span>
                                <input name="isImageDelete" type="hidden" value="0">
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
                        <div class="col-sm-3">
                            <div class="mb-3 required">
                                <label for="email">Email</label>
                                <input id="email" name="email" type="text" class="form-control" placeholder="Email" value="{{ isset($employee)?$employee->email:old('email')}}">
                                @error('email') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="mb-3 required">
                                <label for="phone">Mobile</label>
                                <input id="phone" name="phone" type="text" class="form-control" placeholder="Mobile" value="{{ isset($employee)?$employee->phone:old('phone')}}">
                                @error('phone') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="mb-3 {{ isset($employee)?'':'required'}}">
                                <label for="horizontal-password-input">Password</label>
                                <input type="password" name="password" class="form-control" id="horizontal-password-input" placeholder="Enter Your Password">
                                @error('password') <p class="text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label for="email">Role</label>
                                <select id="role_id" name="role_id" class="form-control select2">
                                    <option value="">Select</option>
                                    @foreach ($roles as $role )
                                        {{-- @if($role->id != Utility::ROLE_ADMIN) --}}
                                        <option value="{{ encrypt($role->id) }}" {{ isset($employee)&&($employee->roles->contains($role->id))?'selected':''}}>{{ $role->display_name }}</option>
                                        {{-- @endif --}}
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
<script>
    $(document).ready(function() {
        $('#imageContainer').find('button').click(function() {
            $('#imageContainer').hide();
            $('#fileContainer').show();
            $('input[name="isImageDelete"]').val(1);
        })

        $('#fileContainer').find('button').click(function() {
            $('#fileContainer').hide();
            $('#imageContainer').show();
            $('input[name="isImageDelete"]').val(0);
        })
    });
</script>
<script>
    $(document).ready(function() {
        @if(isset($employee))
            getdistrict({{ Utility::STATE_ID_KERALA }},{{ $employee->district_id }});
        @else
            getdistrict({{ Utility::STATE_ID_KERALA }},0);
        @endif
    });
    function getdistrict(val,d_id) {
        var formData = {'s_id' : val, 'd_id':d_id};
        $.ajax({
            type: "POST",
            url: "{{ route('admin.employees.list.districts') }}",
            data:formData,
            success: function(data){
                $("#district-list").html(data);
                console.log(data);
            }
        });
    }
</script>
@endsection
