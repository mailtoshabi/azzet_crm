@extends('admin.layouts.executive.master')
@section('title') @lang('translation.Add_Product') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('admin.dir_components.breadcrumb')
@slot('li_1') @lang('translation.Catalogue_Manage') @endslot
@slot('li_2') @lang('translation.Product_Manage') @endslot
@slot('title') @if(isset($product)) @lang('translation.Edit_Product') @else @lang('translation.Add_Product') @endif @endslot
@endcomponent
<div class="row">
    <form method="POST" action="{{ isset($product)? route('executive.products.update') : route('executive.products.store')  }}" enctype="multipart/form-data">
        @csrf
        @if (isset($product))
            <input type="hidden" name="product_id" value="{{ encrypt($product->id) }}" />
            <input type="hidden" name="_method" value="PUT" />
        @endif

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Product Details</h4>
                    <p class="card-title-desc">{{ isset($product)? 'Edit' : "Enter" }} the Details of your Products</p>
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="control-label">Category</label>
                                    <select id="category_id" name="category_id" class="form-control select2">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @isset($product) {{ $category->id==$product->category->id ? 'selected':'' }} @endisset>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input id="name" name="name" type="text" class="form-control"  placeholder="Name" value="{{ isset($product)?$product->name:old('name')}}">
                                    @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Notes</label>
                                    <textarea class="form-control" rows="2" placeholder="Enter notes, if any" id="description" name="description">{{ isset($product)?$product->description:old('description ')}}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="control-label">Image</label>
                                    <span id="imageContainer" @if(isset($product)&&empty($product->image)) style="display: none" @endif>
                                        @if(isset($product)&&!empty($product->image))
                                            <img src="{{ URL::asset(App\Models\Category::DIR_STORAGE . $product->image) }}" alt="" class="avatar-xxl rounded-circle me-2">
                                            <button type="button" class="btn-close" aria-label="Close"></button>
                                        @endif
                                    </span>

                                    <span id="fileContainer" @if(isset($product)&&!empty($product->image)) style="display: none" @endif>
                                        <input id="image" name="image" type="file" class="form-control"  placeholder="File">
                                        @if(isset($product)&&!empty($product->image))
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
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">{{ isset($product) ? 'Update' : 'Save' }}</button>
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
@endsection
