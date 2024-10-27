@extends('admin.layouts.master')
@section('title') @lang('translation.Add_Uom') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('admin.dir_components.breadcrumb')
@slot('li_1') @lang('translation.Account_Settings') @endslot
@slot('li_2') @lang('translation.Uom_Manage') @endslot
@slot('title') @if(isset($uom)) @lang('translation.Edit_Uom') @else @lang('translation.Add_Uom') @endif @endslot
@endcomponent
<div class="row">
    <form method="POST" action="{{ isset($uom)? route('admin.uoms.update') : route('admin.uoms.store')  }}" enctype="multipart/form-data">
        @csrf
        @if (isset($uom))
            <input type="hidden" name="uom_id" value="{{ encrypt($uom->id) }}" />
            <input type="hidden" name="_method" value="PUT" />
        @endif

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('translation.Uom_Manage') Details</h4>
                    <p class="card-title-desc">{{ isset($uom)? 'Edit' : "Enter" }} the Details of UOM</p>
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input id="name" name="name" type="text" class="form-control"  placeholder="Name" value="{{ isset($uom)?$uom->name:old('name')}}">
                                    @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                        </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">{{ isset($uom) ? 'Update' : 'Save' }}</button>
                        <button type="reset" class="btn btn-secondary waves-effect waves-light">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <input name="isImageDelete" type="hidden" value="0">
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
