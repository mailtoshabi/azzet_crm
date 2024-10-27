@extends('admin.layouts.master')
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
@if(isset($product) && !$product->is_approved )
<div class="alert alert-warning alert-top-border alert-dismissible fade show" role="alert">
    <i class="mdi mdi-check-all me-3 align-middle text-warning"></i><strong>Warning</strong> - This Product is yet to approve !!
</div>
@endif
<div class="row">
    <form method="POST" action="{{ isset($product)? route('admin.products.update') : route('admin.products.store')  }}" enctype="multipart/form-data">
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
                                    <label for="name">Name</label>
                                    <input id="name" name="name" type="text" class="form-control"  placeholder="Name" value="{{ isset($product)?$product->name:old('name')}}">
                                    @error('name') <p class="text-danger">{{ $message }}</p> @enderror
                                </div>
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
                                    <label for="profit">Profit</label>
                                    <input id="profit" name="profit" type="text" class="form-control"  placeholder="Profit" value="{{ isset($product)?$product->profit:old('profit')}}">
                                    @error('profit') <p>{{ $message }}</p> @enderror
                                </div>
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
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Notes</label>
                                    <textarea class="form-control" rows="2" placeholder="Enter notes, if any" id="description" name="description">{{ isset($product)?$product->description:old('description ')}}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="control-label">Unit of Measure</label>
                                    <select id="uom_id" name="uom_id" class="form-control select2">
                                        <option value="">Select Unit</option>
                                        @foreach ($uoms as $uom)
                                        <option value="{{ $uom->id }}" @isset($product) {{ $uom->id==$product->uom_id ? 'selected':'' }} @endisset>{{ $uom->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('uom_id') <p class="text-danger">{{ $message }}</p> @enderror
                                    <a target="_blank" href="{{ route('admin.uoms.create') }}"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Add New Unit</a>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="control-label">HSN Code</label>
                                    <select id="hsn_id" name="hsn_id" class="form-control select2">
                                        <option value="">Select Code</option>
                                        @foreach ($hsns as $hsn)
                                        <option value="{{ $hsn->id }}" @isset($product) {{ $hsn->id==$product->hsn_id ? 'selected':'' }} @endisset>{{ $hsn->name }} - GST {{ $hsn->tax_slab->name }}%</option>
                                        @endforeach
                                    </select>
                                    @error('hsn_id') <p class="text-danger">{{ $message }}</p> @enderror
                                    <a target="_blank" href="{{ route('admin.hsns.create') }}"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp;Add New Code</a>
                                </div>
                            </div>
                        </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Components</h4>
                    <p class="card-title-desc">{{ isset($product)? 'Edit' : "Add" }} details of components</p>
                </div>
                <div class="card-body" id="component_container">
                    @isset($product)
                        @foreach ($product->components as $index => $product_component)
                            <div class="row close_container" id="close_container_{{ $index }}">

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="control-label">Component Name</label>
                                        <select id="component_names-{{ $index }}" name="component_names[{{ $index }}]" class="form-control select2" onChange="getcost(this.value,{{ $index }});">
                                            <option value="">Select Component</option>
                                            @foreach ($components as $component)
                                                <option value="{{ $component->id }}" {{ $component->id==$product_component->id ? 'selected':'' }}>{{ $component->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="mb-3">
                                        <label>Cost</label>
                                        <input id="costs-{{ $index }}" name="costs[{{ $index }}]" type="text" class="form-control"  placeholder="Cost" value="{{ $product_component->pivot->cost }}">
                                        <input id="o_costs-{{ $index }}" name="o_costs[{{ $index }}]" type="hidden" value="{{ $product_component->pivot->o_cost }}">
                                    </div>
                                </div>
                                <a class="btn-close" data-target="#close_container_{{ $index }}"><i class="fa fa-trash"></i></a>
                            </div>
                        @endforeach

                    @endisset
                    @empty($product)
                        <div class="row">


                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="control-label">Component Name</label>
                                    <select id="component_names-0" name="component_names[0]" class="form-control select2" onChange="getcost(this.value,0);" >
                                        <option value="">Select Component</option>
                                        @foreach ($components as $component)
                                            <option value="{{ $component->id }}">{{ $component->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="mb-3">
                                    <label>Cost</label>
                                    <input id="costs-0" name="costs[0]" type="text" class="form-control"  placeholder="Cost" value="">
                                    <input id="o_costs-0" name="o_costs[0]" type="hidden" value="">
                                </div>
                            </div>
                        </div>
                    @endempty
                </div>
                <div class="p-4 pt-1">
                    <a href="#" data-toggle="add-more" data-template="#template_component"
                    data-close=".wb-close" data-container="#component_container"
                    data-count="{{ isset($product) ? $product->components->count()-1 : 0 }}"
                    data-addindex='[{"selector":".component_names","attr":"name", "value":"component_names"},{"selector":".costs","attr":"name", "value":"costs"},{"selector":".o_costs","attr":"name", "value":"o_costs"}]'
                    data-plugins='[{"selector":".component_names","plugin":"select2"}]'
                    data-onchanges='[{"selector":".component_names","attr":"onChange"}]'
                    data-increment='[{"selector":".component_names","attr":"id", "value":"component_names"},{"selector":".costs","attr":"id", "value":"costs"},{"selector":".o_costs","attr":"id", "value":"o_costs"}]'><i
                                class="fa fa-plus-circle"></i>&nbsp;&nbsp;New Component</a>
                </div>
            </div>


            <div class="row hidden" id="template_component">

                <div class="col-sm-6">
                    <div class="mb-3">
                        <label class="control-label">Component Name</label>
                        <select id="" name="" class="form-control component_names" onChange="">
                            <option value="">Select Component</option>
                            @foreach ($components as $component)
                                <option value="{{ $component->id }}">{{ $component->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="mb-3">
                        <label>Cost</label>
                        <input id="" name="" type="text" class="form-control costs"  placeholder="Cost" value="">
                        <input id="" name="" type="hidden" class="o_costs" value="">
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">{{ isset($product) ? $product->is_approved?'Update':'Update & Approve' : 'Save' }}</button>
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
        /*X-CSRF-TOKEN*/
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
    });
    function getcost(val, position) {
        var formData = {'component_id' : val, 'position':position};
        $.ajax({
            type: "POST",
            url: "{{ route('admin.products.get_cost') }}",
            data: formData,
            success: function(data){
                $("#costs-"+position).val(data);
                $("#o_costs-"+position).val(data);
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        // $('.select2_component_names').select2();
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
                    // if(typeof(have_child)  === "undefined") {
                        $el.find(p.selector).attr(p.attr, p.value +"-"+count);
                    // }else {
                    //     $el.find(p.selector).attr(p.attr, p.value +"-"+count+"-"+have_child);
                    // }
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
