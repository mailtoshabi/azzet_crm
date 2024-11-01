@extends('admin.layouts.executive.master')
@section('title') @lang('translation.Proforma_Details') @endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">

                        <h6 class="text-primary">Invoice To</h6>
                        <p class="mb-2"><b>{{ $sale->estimate->customer->name }}</b> </p>
                        @unless (empty($sale->estimate->customer->trade_name))
                            <p class="mb-2">{{ $sale->estimate->customer->trade_name }} (Trade Name) </p>
                        @endunless
                        @unless (empty($sale->estimate->customer->address1))<p class="text-muted mb-0">{{ $sale->estimate->customer->address1 }}</p>@endunless
                        @unless (empty($sale->estimate->customer->address2))<p class="text-muted mb-0">{{ $sale->estimate->customer->address2 }}</p>@endunless
                        @unless (empty($sale->estimate->customer->address3))<p class="text-muted mb-0">{{ $sale->estimate->customer->address3 }}</p>@endunless
                        <p class="text-muted mb-0">{{ $sale->estimate->customer->city }}</p>
                        <p class="text-muted mb-0">{{ $sale->estimate->customer->district->name }} District</p>
                        <p class="text-muted mb-0">{{ $sale->estimate->customer->state->name }} - {{ $sale->estimate->customer->postal_code }}</p>
                        {{-- <p class="text-muted mb-2">{{ $sale->estimate->customer->postal_code }}</p> --}}
                        <p class="text-primary mb-0">Mob:{{ $sale->estimate->customer->phone }}</p>
                        <p class="text-success mb-2">Email:{{ $sale->estimate->customer->email }}</p>

                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Status : <span id="status_id">{{ Utility::saleStatus()[$sale->status]['name'] }}</span> <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                {{-- @foreach (Utility::saleStatus() as $index => $status ) --}}
                                    <li><a data-plugin="change-status" href="{{ route('executive.sales.changeStatus',[encrypt($sale->id),encrypt(Utility::STATUS_OUT)]) }}" class="dropdown-item">{{ Utility::saleStatus()[Utility::STATUS_OUT]['name'] }}</a></li>
                                    <li><a data-plugin="change-status" href="{{ route('executive.sales.changeStatus',[encrypt($sale->id),encrypt(Utility::STATUS_DELIVERED)]) }}" class="dropdown-item">{{ Utility::saleStatus()[Utility::STATUS_DELIVERED]['name'] }}</a></li>
                                {{-- @endforeach --}}

                                {{-- <li><a class="dropdown-item" href="#">Dropdown link</a></li> --}}
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 azzet_invoice">
                        <br>
                        <p class="mb-0">Date : {{ $sale->created_at->format('d-m-Y') }}</p>
                        <p class="mb-2">Order ID : {{ $sale->invoice_no }} </p>
                        @unless (empty($sale->estimate->customer->gstin))<p class="mb-2"><b>{!! 'GSTIN/UIN: '. $sale->estimate->customer->gstin !!}</b></p>@endunless
                        State Name :  {{ $sale->estimate->customer->state->name }}, Code : {{ $sale->estimate->customer->state->gst_code }} <br>
                        @unless (empty($sale->estimate->customer->cin))<p class="mb-2">{!! 'CIN: '. $sale->estimate->customer->cin !!}</p>@endunless
                        {{-- <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Status : New <i class="mdi mdi-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                <li><a class="dropdown-item" href="#">Dropdown link</a></li>
                                <li><a class="dropdown-item" href="#">Dropdown link</a></li>
                            </ul>
                        </div> --}}

                        <div class="mt-4">
                            <a data-plugin="confirm-data" data-confirmtext="Do you really want to download the Invoice?" href="{{ route('executive.sales.download.invoice',encrypt($sale->id)) }}" class="btn btn-primary waves-effect waves-light w-sm">
                                <i class="fas fa-download d-block font-size-12"></i> Download Invoice
                            </a>
                            <a data-plugin="confirm-data" data-confirmtext="Do you really want to print the Invoice?" href="{{ route('executive.sales.view.invoice',encrypt($sale->id)) }}" class="btn btn-secondary waves-effect waves-light w-sm">
                                <i class="fas fa-print d-block font-size-12"></i> Print Invoice
                            </a>

                        </div>
                    </div>

                </div>
            </div>

            <div class="card-body">
                <div class="row">

                    <div class="table-responsive">
                        <div class="margin-top">
                            <table cellpadding="0" cellspacing="0"  class="w-full">

                                <tr>
                                    <td class="w-full" colspan="2">
                                        <table class="w-full">
                                            <tr class="center height-20" >
                                                <td class="has-border noright w-3 vertical-m">SI No</td>
                                                <td colspan="3" class="has-border noright w-35 vertical-m">Description of Goods</td>
                                                <td class="has-border noright vertical-m">HSN/SAC</td>
                                                <td class="has-border noright vertical-m">Quantity</td>
                                                <td class="has-border noright vertical-m">Rate</td>
                                                <td class="has-border noright vertical-m">Per</td>
                                                <td class="has-border vertical-m">Amount</td>
                                            </tr>
                                            <?php $sino = 1; ?>
                                            @foreach($sale->products as $product)
                                            <tr class="center height-20" >
                                                <td class="has-border notop noright nobottom">{{ $sino }}</td>
                                                <td colspan="3" class="has-border notop noright nobottom left-align"><b>{{ $product->name }}</b><br><small>{{ $product->description }}</small></td>
                                                <td class="has-border notop noright nobottom">{{ $product->hsn->name }}</td>
                                                <td class="has-border notop noright nobottom">{{ $product->pivot->quantity }} {{ $product->uom->name }}</td>
                                                <td class="has-border notop noright nobottom">{{ Utility::formatPrice($product->pivot->price) }}</td>
                                                <td class="has-border notop noright nobottom">{{ $product->uom->name }}</td>
                                                <td class="has-border notop nobottom  right-align"><b>{{ Utility::formatPrice($product->pivot->price*$product->pivot->quantity) }}</b></td>
                                            </tr>

                                            <?php $sino++; ?>
                                            @endforeach
                                            <tr class="center height-20" >
                                                <td class="has-border notop noright nobottom"></td>
                                                <td colspan="3" class="has-border notop noright nobottom right-align"></td>
                                                <td class="has-border notop noright nobottom"></td>
                                                <td class="has-border notop noright nobottom"></td>
                                                <td class="has-border notop noright nobottom"></td>
                                                <td class="has-border notop noright nobottom"></td>
                                                <td class="has-border nobottom right-align">{{ Utility::formatPrice($sale->sub_total) }}</td>
                                            </tr>
                                            @unless (($sale->delivery_charge==0))
                                            <tr class="center" >
                                                <td class="has-border notop noright nobottom"></td>
                                                <td colspan="3" class="has-border notop noright nobottom right-align"><b>Freight Outward</b></td>
                                                <td class="has-border notop noright nobottom"></td>
                                                <td class="has-border notop noright nobottom"></td>
                                                <td class="has-border notop noright nobottom"></td>
                                                <td class="has-border notop noright nobottom"></td>
                                                <td class="has-border notop nobottom right-align"><b>{{ Utility::formatPrice($sale->delivery_charge) }}</b></td>
                                            </tr>
                                            @endunless
                                            @if($sale->estimate->customer->state->id==Utility::STATE_ID_KERALA)
                                            <tr class="center" >
                                                <td class="has-border notop noright nobottom"></td>
                                                <td colspan="3" class="has-border notop noright nobottom right-align"><b>CGST</b></td>
                                                <td class="has-border notop noright nobottom"></td>
                                                <td class="has-border notop noright nobottom"></td>
                                                <td class="has-border notop noright nobottom"></td>
                                                <td class="has-border notop noright nobottom"></td>
                                                <td class="has-border notop nobottom right-align"><b>{{ Utility::formatPrice($sale->total_igst/2) }}</b></td>
                                            </tr>
                                            <tr class="center" >
                                                <td class="has-border notop noright nobottom"></td>
                                                <td colspan="3" class="has-border notop noright nobottom right-align"><b>SGST</b></td>
                                                <td class="has-border notop noright nobottom"></td>
                                                <td class="has-border notop noright nobottom"></td>
                                                <td class="has-border notop noright nobottom"></td>
                                                <td class="has-border notop noright nobottom"></td>
                                                <td class="has-border notop nobottom right-align"><b>{{ Utility::formatPrice($sale->total_igst/2) }}</b></td>
                                            </tr>
                                            @else
                                            <tr class="center" >
                                                <td class="has-border notop noright nobottom"></td>
                                                <td colspan="3" class="has-border notop noright nobottom right-align"><b>IGST</b></td>
                                                <td class="has-border notop noright nobottom"></td>
                                                <td class="has-border notop noright nobottom"></td>
                                                <td class="has-border notop noright nobottom"></td>
                                                <td class="has-border notop noright nobottom"></td>
                                                <td class="has-border notop nobottom right-align"><b>{{ Utility::formatPrice($sale->total_igst) }}</b></td>
                                            </tr>
                                            @endif
                                            @unless (($sale->discount==0))
                                                <tr class="center" >
                                                    <td class="has-border notop nobottom noright"></td>
                                                    <td colspan="3" class="has-border notop nobottom noright right-align"><b>Discount</b></td>
                                                    <td class="has-border notop nobottom noright"></td>
                                                    <td class="has-border notop nobottom noright"></td>
                                                    <td class="has-border notop nobottom noright"></td>
                                                    <td class="has-border notop nobottom noright"></td>
                                                    <td class="has-border notop nobottom right-align"><b>{{ Utility::formatPrice($sale->discount) }}</b></td>
                                                </tr>
                                            @endunless
                                            @unless (($sale->round_off==0))
                                                <tr class="center" >
                                                    <td class="has-border notop nobottom noright"></td>
                                                    <td colspan="3" class="has-border notop nobottom noright right-align"><b>Round Off</b></td>
                                                    <td class="has-border notop nobottom noright"></td>
                                                    <td class="has-border notop nobottom noright"></td>
                                                    <td class="has-border notop nobottom noright"></td>
                                                    <td class="has-border notop nobottom noright"></td>
                                                    <td class="has-border notop nobottom right-align"><b>{{ Utility::formatPrice($sale->round_off) }}</b></td>
                                                </tr>
                                            @endunless

                                            <tr class="center height-20" >
                                                <td class="has-border noright"></td>
                                                <td colspan="3" class="has-border noright right-align vertical-m">Total</td>
                                                <td class="has-border noright"></td>
                                                <td class="has-border noright vertical-m">{{ $sale->sub_quantity }} {{ $product->uom->name }}</td>
                                                <td class="has-border noright"></td>
                                                <td class="has-border noright"></td>
                                                <td class="has-border vertical-m right-align"><b>{{ Utility::formatPrice($sale->sub_total+$sale->total_igst+$sale->delivery_charge-$sale->round_off-$sale->discount) }}</b></td>
                                            </tr>

                                            <tr class="center height-20" >
                                                <td colspan="8" class="has-border notop noright left-align"><small>Amount Chargeable (in words)</small><br>
                                                    <b>{{ Utility::CURRENCY_DISPLAY . ' ' . Utility::currencyToWords(($sale->sub_total+$sale->total_igst+$sale->delivery_charge-$sale->round_off-$sale->discount)) }}</b>
                                                </td>
                                                <td class="has-border notop noleft right-align">E. & O.E</td>
                                            </tr>


                                            @if($sale->estimate->customer->state->id==Utility::STATE_ID_KERALA)
                                                <tr class="center height-20" >
                                                    <td rowspan="2" colspan="3" class="has-border notop noright vertical-m w-quarter">HSN/SAC</td>
                                                    <td rowspan="2" class="has-border notop noright vertical-m">Taxable Value</td>
                                                    <td colspan="2" class="has-border notop norigh vertical-m">CGST</td>
                                                    <td colspan="2" class="has-border notop norigh vertical-m">SGST/UTGST</td>
                                                    <td rowspan="2" class="has-border notop vertical-m"><b>Total Tax Amount</b></td>
                                                </tr>
                                                <tr class="center height-20" >
                                                    <td class="has-border notop norigh vertical-m">Rate</td>
                                                    <td class="has-border notop norigh vertical-m">Amount</td>
                                                    <td class="has-border notop norigh vertical-m">Rate</td>
                                                    <td class="has-border notop norigh vertical-m">Amount</td>
                                                </tr>
                                                @foreach($sale->products as $product)
                                                <tr class="center height-20" >
                                                    <td colspan="3" class="has-border notop noright left-align w-quarter">{{ $product->hsn->name }}</td>
                                                    <td class="has-border notop noright">{{ Utility::formatPrice($product->pivot->price*$product->pivot->quantity) }}</td>
                                                    <td class="has-border notop noright">{{ $product->hsn->tax_slab->name/2 }}%</td>
                                                    <td class="has-border notop noright">{{ Utility::formatPrice((($product->pivot->price*$product->pivot->quantity)*($product->hsn->tax_slab->name/100))/2) }}</td>
                                                    <td class="has-border notop noright">{{ $product->hsn->tax_slab->name/2 }}%</td>
                                                    <td class="has-border notop noright">{{ Utility::formatPrice((($product->pivot->price*$product->pivot->quantity)*($product->hsn->tax_slab->name/100))/2) }}</td>
                                                    <td class="has-border notop">{{ Utility::formatPrice(($product->pivot->price*$product->pivot->quantity)*($product->hsn->tax_slab->name/100)) }}</td>
                                                </tr>
                                                @endforeach
                                                <tr class="center height-40" >
                                                    <td colspan="3" class="has-border notop noright right-align  vertical-m w-quarter"><b>Total</b></td>
                                                    <td class="has-border notop noright  vertical-m"><b>{{ Utility::formatPrice($sale->sub_total) }}</b></td>
                                                    <td class="has-border notop noright"></td>
                                                    <td class="has-border notop noright  vertical-m"><b>{{ Utility::formatPrice($sale->total_sgst) }}</b></td>
                                                    <td class="has-border notop noright"></td>
                                                    <td class="has-border notop  vertical-m"><b>{{ Utility::formatPrice($sale->total_sgst) }}</b></td>
                                                    <td class="has-border notop vertical-m"><b>{{ Utility::formatPrice($sale->total_igst) }}</b></td>
                                                </tr>
                                            @else
                                                <tr class="center height-20" >
                                                    <td rowspan="2" colspan="5" class="has-border notop noright vertical-m">HSN/SAC</td>
                                                    <td rowspan="2" class="has-border notop noright vertical-m">Taxable Value</td>
                                                    <td colspan="2" class="has-border notop norigh vertical-m">IGST</td>
                                                    <td rowspan="2" class="has-border notop vertical-m"><b>Total Tax Amount</b></td>
                                                </tr>
                                                <tr class="center height-20" >
                                                    <td class="has-border notop norigh vertical-m">Rate</td>
                                                    <td class="has-border notop noright vertical-m">Amount</td>
                                                </tr>
                                                @foreach($sale->products as $product)
                                                <tr class="center height-20" >
                                                    <td colspan="5" class="has-border notop noright left-align">{{ $product->hsn->name }}</td>
                                                    <td class="has-border notop noright">{{ Utility::formatPrice($product->pivot->price*$product->pivot->quantity) }}</td>
                                                    <td class="has-border notop noright">{{ $product->hsn->tax_slab->name }}%</td>
                                                    <td class="has-border notop noright">{{ Utility::formatPrice(($product->pivot->price*$product->pivot->quantity)*($product->hsn->tax_slab->name/100)) }}</td>
                                                    <td class="has-border notop">{{ Utility::formatPrice(($product->pivot->price*$product->pivot->quantity)*($product->hsn->tax_slab->name/100)) }}</td>
                                                </tr>
                                                @endforeach
                                                <tr class="center height-40" >
                                                    <td colspan="5" class="has-border notop noright right-align  vertical-m"><b>Total</b></td>
                                                    <td class="has-border notop noright  vertical-m"><b>{{ Utility::formatPrice($sale->sub_total) }}</b></td>
                                                    <td class="has-border notop noright"></td>
                                                    <td class="has-border notop noright  vertical-m"><b>{{ Utility::formatPrice($sale->total_igst) }}</b></td>
                                                    <td class="has-border notop  vertical-m"><b>{{ Utility::formatPrice($sale->total_igst) }}</b></td>
                                                </tr>
                                            @endif

                                            <tr class="center height-20" >
                                                <td colspan="9" class="has-border notop left-align"><small>Tax Amount (in words)  : </small>{{ Utility::CURRENCY_DISPLAY . ' ' . Utility::currencyToWords($sale->total_igst)}}</td>
                                            </tr>


                                            {{-- <tr class="center" >
                                                <td colspan="3" class="w-half has-border notop nobottom noright left-align vertical-b">Company's PAN : AACCF6875F</td>
                                                <td colspan="4" class="w-half has-border notop noleft left-align">
                                                    Company's Bank Details<br>
                                                    Bank Name : ICICI BANK<br>
                                                    A/c No. : 016005008083<br>
                                                    Branch & IFS Code: MODEL TOWN NEW DELHI & ICIC0000160</td>
                                            </tr>
                                            <tr class="center" >
                                                <td colspan="3" class="w-half has-border notop noright left-align">
                                                    <u><small>Declaration</small></u><br>
                                                    We declare that this invoice shows the actual price of the
                                                    goods described and that all particulars are true and
                                                    correct.
                                                </td>
                                                <td colspan="4" class="w-half has-border notop right-align">
                                                    for Fresco Print Pack Private Limited<br>
                                                    <br>
                                                    <br>
                                                    Authorised Signatory</td>
                                            </tr> --}}


                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>


    </div>
</div>
<!-- end row -->
@endsection

@section('css')
<link href="{{ URL::asset('assets/css/invoice.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('script')
<script src="{{ URL::asset('assets/libs/datatables.net/datatables.net.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-bs4/datatables.net-bs4.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/datatables.net-responsive/datatables.net-responsive.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/datatable-pages.init.js') }}"></script>

<script>

    $(document).ready(function() {
        $('#add_freight').on('click', function() {

            // SweetAlert2 popup with input fields
            Swal.fire({
                title: 'Add Your Delivery Charge',
                html:
                    '<input type="text" id="delivery_charge" class="form-control" value="{{ Utility::formatPrice($sale->delivery_charge) }}" placeholder="Name"><br>' +
                    '<input type="hidden" id="sale_id" class="form-control" value="{{ encrypt($sale->id) }}">',
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: 'Submit',
                preConfirm: () => {
                    const delivery_charge = document.getElementById('delivery_charge').value;
                    const sale_id = document.getElementById('sale_id').value;

                    // Check if the inputs are valid
                    if (!delivery_charge) {
                        Swal.showValidationMessage('Please Enter Delivery charge');
                        return false;
                    }
                    return { delivery_charge: delivery_charge, sale_id: sale_id };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Get input values from the SweetAlert2 popup
                    const delivery_charge = result.value.delivery_charge;
                    const sale_id = result.value.sale_id;

                    // Send the data using AJAX
                    $.ajax({
                        url: '{{ route("admin.sales.addFreight") }}',
                        type: 'POST',
                        data: { delivery_charge: delivery_charge, sale_id: sale_id },
                        success: function(response) {
                            Swal.fire(
                                'Success!',
                                'Your data has been submitted.',
                                'success'
                            ).then((result) => {
                                refreshPage();
                            });
                        },
                        error: function() {
                            Swal.fire(
                                'Error!',
                                'There was a problem with the submission.',
                                'error'
                            );
                        }
                    });
                }
            });
        });

        $(document).on('click','[data-plugin="change-status"]',function(e) {
            e.preventDefault();
            if (!confirm('Do you want to change the status?')) return;
            var url = $(this).attr('href');
            $.ajax({
                type: "GET",
                url: url,
                success: function (data) {
                    refreshPage();
                }
            });
	    });

    });

</script>
{{-- <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script> --}}
@endsection
