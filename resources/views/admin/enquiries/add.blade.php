@extends('admin.layouts.master')
@section('title') @lang('translation.Add_Enquiry') @endsection
@section('css')
<link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@component('admin.dir_components.breadcrumb')
@slot('li_1') @lang('translation.Proforma_Manage') @endslot
@slot('li_2') @lang('translation.Enquiry_Manage') @endslot
@slot('title') @if(isset($enquiry)) @lang('translation.Edit_Enquiry') @else @lang('translation.Add_Enquiry') @endif @endslot
@endcomponent
@if(session()->has('error'))
<div class="alert alert-danger alert-top-border alert-dismissible fade show" role="alert">
    <i class="mdi mdi-check-all me-3 align-middle text-danger"></i><strong>Error</strong> - {{ session()->get('error') }}
</div>
@endif
@if(isset($enquiry) && !$enquiry->is_approved )
<div class="alert alert-warning alert-top-border alert-dismissible fade show" role="alert">
    <i class="mdi mdi-check-all me-3 align-middle text-warning"></i><strong>Warning</strong> - This Enquiry is yet to approve !!
</div>
@endif
@if(isset($enquiry) && $enquiry->is_approved && !$enquiry->estimate )
<div class="alert alert-warning alert-top-border alert-dismissible fade show" role="alert">
    <i class="mdi mdi-check-all me-3 align-middle text-warning"></i><strong>Warning</strong> - This Enquiry is yet to convert as Estimate !!
</div>
@endif
<div class="row">
    <form method="POST" action="{{ isset($enquiry)? route('admin.enquiries.update') : route('admin.enquiries.store')  }}" enctype="multipart/form-data">
        @csrf
        @if (isset($enquiry))
            <input type="hidden" name="enquiry_id" value="{{ encrypt($enquiry->id) }}" />
            <input type="hidden" name="_method" value="PUT" />
        @endif

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Enquiry Details</h4>
                    <p class="card-title-desc">{{ isset($enquiry)? 'Edit' : "Enter" }} the Details of Enquiries</p>
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="control-label">@lang('translation.Customer')</label>
                                    @if(isset($enquiry) && !$enquiry->customer->is_approved )
                                        <p class="text-danger">The Customer is yet to <a href="{{ route('admin.customers.index') }}" target="_blank">approve</a>
                                    @endif
                                    <select id="customer_id" name="customer_id" class="form-control select2">
                                        <option value="">Select @lang('translation.Customer')</option>
                                        @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" @isset($enquiry) {{ $customer->id==$enquiry->customer->id ? 'selected':'' }} @endisset>{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('customer_id') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>
                                <p><a href="{{ route('admin.customers.create') }}"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;New @lang('translation.Customer')</a></p>
                            </div>

                        </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Products</h4>
                    <p class="card-title-desc">{{ isset($enquiry)? 'Edit' : "Add" }} details of Products</p>
                </div>
                <div class="card-body" id="product_container">
                    @isset($enquiry)
                        @foreach ($enquiry->products as $index => $enquiry_product)
                            <div class="row close_container" id="close_container_{{ $index }}">

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="control-label">Product</label>
                                        <select id="products-{{ $index }}" name="products[{{ $index }}]" class="form-control select2">
                                            <option value="">Select Product</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}" {{ $product->id==$enquiry_product->id ? 'selected':'' }}>{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="mb-3">
                                        <label>Quantity</label>
                                        <input id="quantities-{{ $index }}" name="quantities[{{ $index }}]" type="text" class="form-control"  placeholder="Quantity" value="{{ $enquiry_product->pivot->quantity }}">
                                    </div>
                                </div>
                                <a class="btn-close" data-target="#close_container_{{ $index }}"><i class="fa fa-trash"></i></a>
                            </div>
                        @endforeach

                    @endisset
                    @empty($enquiry)
                        <div class="row">


                            <div class="col-sm-6">

                                <div class="mb-3">
                                    <label class="control-label">Product</label>
                                    <select id="products-0" name="products[0]" class="form-control select2" >
                                        <option value="">Select Product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="mb-3">
                                    <label>Quantity</label>
                                    <input id="quantities-0" name="quantities[0]" type="text" class="form-control"  placeholder="Quantity" value="">
                                </div>
                            </div>
                        </div>
                    @endempty
                </div>
                <div class="p-4 pt-1">
                    <a href="#" data-toggle="add-more" data-template="#template_product"
                    data-close=".wb-close" data-container="#product_container"
                    data-count="{{ isset($enquiry) ? $enquiry->products->count()-1 : 0 }}"
                    data-addindex='[{"selector":".products","attr":"name", "value":"products"},{"selector":".quantities","attr":"name", "value":"quantities"}]'
                    data-plugins='[{"selector":".products","plugin":"select2"}]'
                    data-increment='[{"selector":".products","attr":"id", "value":"products"},{"selector":".quantities","attr":"id", "value":"quantities"}]'><i
                                class="fa fa-plus-circle"></i>&nbsp;&nbsp;Add Item</a>
                </div>
            </div>

            <div class="row hidden" id="template_product">
                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="control-label">Product</label>
                        <select id="" name="" class="form-control products">
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="mb-3">
                        <label>Quantity</label>
                        <input id="" name="" type="text" class="form-control quantities"  placeholder="Quantity" value="">
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="col-sm-12">
                        <div class="mb-3">
                            <label for="description" class="form-label">Notes</label>
                            <textarea class="form-control" rows="2" placeholder="Enter notes, if any" id="description" name="description">{{ isset($enquiry)?$enquiry->description:old('description ')}}</textarea>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">{{ isset($enquiry) ? $enquiry->is_approved?'Update':'Update & Approve' : 'Save' }}</button>
                            @if((isset($enquiry) && (!$enquiry->estimate)&&$enquiry->is_approved))
                                <a href="{{ route('admin.enquiries.convert_to_estimate',encrypt($enquiry->id)).'?status=1' }}" class="btn btn-primary waves-effect waves-light" >Save as Estimate</a>
                            @endif
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

<script>

    $(document).ready(function() {
        // $('.select2_products').select2();
        $(document).on("click", 'a[data-toggle="add-more"]', function(e) {
            e.stopPropagation();
            e.preventDefault();
            var $el = $($(this).attr("data-template")).clone();
            $el.removeClass("hidden");
            $el.attr("id", "");

            var count = $(this).data('count');
            count = typeof count == "undefined" ? 0 : count;
            count = count + 1;
            $(this).data('count', count);

            var addindex = $(this).data("addindex");
            if(typeof addindex == "object") {
                $.each(addindex, function(i, p) {
                    var have_child = p.have_child;
                    if(typeof(have_child)  === "undefined") {
                        $el.find(p.selector).attr(p.attr, p.value + '[' + count + ']');
                    }else {
                        $el.find(p.selector).attr(p.attr, p.value +'['+count+']'+'['+have_child+']' );
                    }
                });
            }

            var increment = $(this).data("increment");
            if(typeof increment == "object") {
                $.each(increment, function(i, p) {
                    var have_child = p.have_child;
                    if(typeof(have_child)  === "undefined") {
                        $el.find(p.selector).attr(p.attr, p.value +"-"+count);
                    }else {
                        $el.find(p.selector).attr(p.attr, p.value +"-"+count+"-"+have_child);
                    }
                });
            }

            var plugins = $(this).data("plugins");
            if(typeof increment == "object") {
                $.each(plugins, function(i, p) {
                if(p.plugin=='select2') {
                    $el.find(p.selector).select2();
                }

            });
            }

            var onchanges = $(this).data("onchanges");
            if(typeof onchanges == "object") {
                $.each(onchanges, function(i, p) {
                    $el.find(p.selector).attr(p.attr, "getcost(this.value," + count + ")");
            });
            }

            $el.hide().appendTo($(this).attr("data-container")).fadeIn();

        });

    })
</script>
@endsection
