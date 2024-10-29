@extends('admin.layouts.master')
@section('title') @lang('translation.Add_Tax') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('admin.dir_components.breadcrumb')
@slot('li_1') @lang('translation.Account_Settings') @endslot
@slot('li_2') @lang('translation.Tax_Manage') @endslot
@slot('title') @if(isset($tax_slab)) @lang('translation.Edit_Tax') @else @lang('translation.Add_Tax') @endif @endslot
@endcomponent
<div class="row">
    <form method="POST" action="{{ isset($tax_slab)? route('admin.tax_slabs.update') : route('admin.tax_slabs.store')  }}" enctype="multipart/form-data">
        @csrf
        @if (isset($tax_slab))
            <input type="hidden" name="tax_slab_id" value="{{ encrypt($tax_slab->id) }}" />
            <input type="hidden" name="_method" value="PUT" />
        @endif

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('translation.Tax_Manage') Details</h4>
                    <p class="card-title-desc">{{ isset($tax_slab)? 'Edit' : "Enter" }} the Details of Tax Slab</p>
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label for="name">GST Percentage</label>
                                    <input id="name" name="name_tax" type="text" class="form-control"  placeholder="GST Percentage" value="{{ isset($tax_slab)?$tax_slab->name:old('name')}}">
                                    @error('name_tax') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                        </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">{{ isset($tax_slab) ? 'Update' : 'Save' }}</button>
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
