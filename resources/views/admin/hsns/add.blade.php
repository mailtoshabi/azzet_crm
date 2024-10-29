@extends('admin.layouts.master')
@section('title') @lang('translation.Add_Hsn') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('admin.dir_components.breadcrumb')
@slot('li_1') @lang('translation.Account_Settings') @endslot
@slot('li_2') @lang('translation.Hsn_Manage') @endslot
@slot('title') @if(isset($hsn)) @lang('translation.Edit_Hsn') @else @lang('translation.Add_Hsn') @endif @endslot
@endcomponent
<div class="row">
    <form method="POST" action="{{ isset($hsn)? route('admin.hsns.update') : route('admin.hsns.store')  }}" enctype="multipart/form-data">
        @csrf
        @if (isset($hsn))
            <input type="hidden" name="hsn_id" value="{{ encrypt($hsn->id) }}" />
            <input type="hidden" name="_method" value="PUT" />
        @endif

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('translation.Hsn_Manage') Details</h4>
                    <p class="card-title-desc">{{ isset($hsn)? 'Edit' : "Enter" }} the Details of HSN</p>
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input id="name" name="name" type="text" class="form-control"  placeholder="Name" value="{{ isset($hsn)?$hsn->name:old('name')}}">
                                    @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="control-label">GST Slab</label>
                                    <select id="tax_slab_id" name="tax_slab_id" class="form-control select2">
                                        <option value="">Select GST Slab</option>
                                        @foreach ($gst_slabs as $gst_slab)
                                        <option value="{{ $gst_slab->id }}" @isset($hsn) {{ $gst_slab->id==$hsn->tax_slab->id ? 'selected':'' }} @endisset>{{ $gst_slab->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('tax_slab_id') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">{{ isset($hsn) ? 'Update' : 'Save' }}</button>
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
