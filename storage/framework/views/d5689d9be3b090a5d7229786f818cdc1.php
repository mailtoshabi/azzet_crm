<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo e($sale->invoice_no.'_' . date('YmdHis')); ?></title>
<style>
    body{
        margin: 0px;
        padding: 0px;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
    }
    h2{
        margin: 0;
    }
    h4 {
        margin: 0;
    }
    @page {
        margin-top:25px;
    }
    .w-full {
        width: 100%;
    }
    .w-half {
        width: 50%;
    }
    .w-quarter {
        width: 25%;
    }
    .w-three-quarter {
        width: 75%;
    }

    .w-3 {
        width: 3%;
    }

    .w-5 {
        width: 5%;
    }

    .w-35 {
        width: 35%;
    }

    table tr.height-20 td {
        height: 20px;
    }

    table tr.height-40 td {
        height: 40px;
    }

    .margin-top {
        margin-top: 0.25rem;
    }
    .footer {
        font-size: 0.875rem;
        padding: 1rem;
        /* background-color: rgb(241 245 249); */
    }
    table {
        width: 100%;
        border-spacing: 0;
        font-size: 13px;
    }
    table tr td {
        vertical-align: top;
    }
    table tr td.vertical-b {
        vertical-align: bottom !important;
    }
    table tr td.vertical-m {
        vertical-align: middle !important;
    }
    table td.has-border {
        border: 1px solid lightgrey;
        border-collapse: collapse;
    }

    table td.has-border.noright {
        border-right: none !important;
    }
    table td.has-border.nobottom {
        border-bottom: none !important;
    }
    table td.has-border.noleft {
        border-left: none !important;
    }
    table td.has-border.notop {
        border-top: none !important;
    }

    /* table tr td.height-big {
        height: 68px;
    } */
    table.products {
        font-size: 0.875rem;
    }
    table.products tr {
        background-color: rgb(96 165 250);
    }
    table.products th {
        color: #ffffff;
        padding: 0.5rem;
    }
    table tr.items {
        background-color: rgb(241 245 249);
    }
    table tr.items td {
        padding: 0.5rem;
        text-align: center;
    }
    table tr.left td {
        text-align: left;
    }

    table tr.center td {
        text-align: center;
    }

    table tr td.left-align {
        text-align: left !important;
    }

    table tr td.right-align {
        text-align: right !important;
    }

    .total {
        text-align: right;
        margin-top: 1rem;
        font-size: 0.875rem;
    }

</style>
</head>
<body>
    <table class="w-full">
        <tr class="center">

            <td class="w-full">
                <h2>Proforma Invoice</h2>
            </td>
        </tr>
    </table>

    <div class="margin-top">
        <table cellpadding="0" cellspacing="0"  class="w-full">
            <tr>
                <td class="w-half">
                    <table class="w-full">
                        <tr class="left">
                            <td class="w-quarter has-border"><?php if(!empty($sale->estimate->branch->image)): ?><img src="data:image/png;base64,<?php echo e(base64_encode(file_get_contents(public_path('storage/branches/' . $sale->estimate->branch->image)))); ?>" class="w-full" style="background-color: black;" ><?php endif; ?></td>
                            <td class="w-three-quarter has-border">
                                <b><?php echo e(!empty($sale->estimate->branch->trade_name) ? $sale->estimate->branch->trade_name : $sale->estimate->branch->name); ?></b><br>
                                <?php if (! (empty($sale->estimate->branch->address1))): ?>
                                    <?php echo e($sale->estimate->branch->address1); ?><br>
                                <?php endif; ?>
                                <?php if (! (empty($sale->estimate->branch->address2))): ?>
                                    <?php echo e($sale->estimate->branch->address2); ?><br>
                                <?php endif; ?>
                                <?php if (! (empty($sale->estimate->branch->address3))): ?>
                                    <?php echo e($sale->estimate->branch->address3); ?><br>
                                <?php endif; ?>
                                <?php if (! (empty($sale->estimate->branch->city))): ?>
                                    <?php echo e($sale->estimate->branch->city); ?><br>
                                <?php endif; ?>
                                <?php if (! (empty($sale->estimate->branch->district))): ?>
                                    <?php echo e($sale->estimate->branch->district->name); ?> District<br>
                                <?php endif; ?>
                                <?php if (! (empty($sale->estimate->branch->state))): ?>
                                    <?php echo e($sale->estimate->branch->state->name); ?> <?php if(!empty($sale->estimate->branch->postal_code)): ?> - <?php echo e($sale->estimate->branch->postal_code); ?> <?php endif; ?><br>
                                <?php endif; ?>
                                <?php if (! (empty($sale->estimate->branch->phone))): ?>
                                    Mob - <?php echo e($sale->estimate->branch->phone); ?><br>
                                <?php endif; ?>
                                <?php if (! (empty($sale->estimate->branch->gstin))): ?>
                                    GSTIN/UIN : <?php echo e($sale->estimate->branch->gstin); ?><br>
                                <?php endif; ?>
                                <?php if (! (empty($sale->estimate->branch->state))): ?>
                                    State Name : <?php echo e($sale->estimate->branch->state->name); ?>, Code : <?php echo e($sale->estimate->branch->state->gst_code); ?><br>
                                <?php endif; ?>
                                <?php if (! (empty($sale->estimate->branch->cin))): ?><?php echo 'CIN: '. $sale->estimate->branch->cin. '<br>'; ?><?php endif; ?>
                                <?php if (! (empty($sale->estimate->branch->email))): ?>
                                    Email : <?php echo e($sale->estimate->branch->email); ?>

                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="w-full has-border notop nobottom">
                                <small>Buyer (Bill to)</small><br>
                                <b><?php echo e(empty($sale->estimate->customer->trade_name)?$sale->estimate->customer->name:$sale->estimate->customer->trade_name); ?></b><br>
                                <?php if (! (empty($sale->estimate->customer->address1))): ?><?php echo $sale->estimate->customer->address1 . '<br>'; ?><?php endif; ?>
                                <?php if (! (empty($sale->estimate->customer->address2))): ?><?php echo $sale->estimate->customer->address2 . '<br>'; ?><?php endif; ?>
                                <?php if (! (empty($sale->estimate->customer->address3))): ?><?php echo $sale->estimate->customer->address3 . '<br>'; ?><?php endif; ?>
                                <?php echo e($sale->estimate->customer->city); ?><br>
                                <?php echo e($sale->estimate->customer->district->name); ?> District  - <?php echo e($sale->estimate->customer->postal_code); ?><br>
                                PH NO: <?php echo e($sale->estimate->customer->phone); ?><br>
                                <?php if (! (empty($sale->estimate->customer->gstin))): ?><?php echo 'GSTIN/UIN: '. $sale->estimate->customer->gstin. '<br>'; ?><?php endif; ?>
                                State Name :  <?php echo e($sale->estimate->customer->state->name); ?>, Code : <?php echo e($sale->estimate->customer->state->gst_code); ?> <br>
                                <?php if (! (empty($sale->estimate->customer->cin))): ?><?php echo 'CIN: '. $sale->estimate->customer->cin. '<br>'; ?><?php endif; ?>
                                <?php if (! (empty($sale->estimate->customer->email))): ?><?php echo 'E-Mail: '. $sale->estimate->customer->email; ?><?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="w-half has-border noleft nobottom notop">
                    <table class="w-full">
                        <tr class="left height-20">
                            <td class="w-half has-border noleft nobottom">Invoice No. <br><?php echo e($sale->invoice_no); ?></td>
                            <td class="w-half has-border noleft nobottom noright">Dated <br><?php echo e($sale->created_at->format('d-M-Y')); ?></td>
                        </tr>
                        <tr class="left height-20">
                            <td class="w-half has-border noleft nobottom">Deleivery Note</td>
                            <td class="w-half has-border noleft nobottom noright">Mode/Terms of Payment <br><b>Advance</b></td>
                        </tr>
                        <tr class="left height-20">
                            <td class="w-half has-border noleft nobottom">Reference No. & Date.</td>
                            <td class="w-half has-border noleft nobottom noright">Other References</td>
                        </tr>
                        <tr class="left height-20">
                            <td class="w-half has-border noleft nobottom">Buyer's Order No.</td>
                            <td class="w-half has-border noleft nobottom noright">Dated</td>
                        </tr>
                        <tr class="left height-20">
                            <td class="w-half has-border noleft nobottom">Dispatch Doc No.</td>
                            <td class="w-half has-border noleft nobottom noright">Delivery Note Date</td>
                        </tr>
                        <tr class="left height-20">
                            <td class="w-half has-border noleft nobottom">Dispatched through</td>
                            <td class="w-half has-border noleft nobottom noright">Destination</td>
                        </tr>
                        <tr class="left">
                            <td colspan="2" class="w-half has-border noleft nobottom noright">Terms of Delivery</td>
                        </tr>
                    </table>
                </td>
            </tr>
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
                        <?php $__currentLoopData = $sale->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="center height-20" >
                            <td class="has-border notop noright nobottom"><?php echo e($sino); ?></td>
                            <td colspan="3" class="has-border notop noright nobottom left-align"><b><?php echo e($product->name); ?></b><br><small><?php echo e($product->description); ?></small></td>
                            <td class="has-border notop noright nobottom"><?php echo e($product->hsn->name); ?></td>
                            <td class="has-border notop noright nobottom"><?php echo e($product->pivot->quantity); ?> <?php echo e($product->uom->name); ?></td>
                            <td class="has-border notop noright nobottom"><?php echo e(Utility::formatPrice($product->pivot->price)); ?></td>
                            <td class="has-border notop noright nobottom"><?php echo e($product->uom->name); ?></td>
                            <td class="has-border notop nobottom  right-align"><b><?php echo e(Utility::formatPrice($product->pivot->price*$product->pivot->quantity)); ?></b></td>
                        </tr>

                        <?php $sino++; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <tr class="center height-20" >
                            <td class="has-border notop noright nobottom"></td>
                            <td colspan="3" class="has-border notop noright nobottom right-align"></td>
                            <td class="has-border notop noright nobottom"></td>
                            <td class="has-border notop noright nobottom"></td>
                            <td class="has-border notop noright nobottom"></td>
                            <td class="has-border notop noright nobottom"></td>
                            <td class="has-border nobottom right-align"><?php echo e(Utility::formatPrice($sale->sub_total)); ?></td>
                        </tr>
                        <?php if (! (($sale->delivery_charge==0))): ?>
                        <tr class="center" >
                            <td class="has-border notop noright nobottom"></td>
                            <td colspan="3" class="has-border notop noright nobottom right-align"><b>Freight Outward</b></td>
                            <td class="has-border notop noright nobottom"></td>
                            <td class="has-border notop noright nobottom"></td>
                            <td class="has-border notop noright nobottom"></td>
                            <td class="has-border notop noright nobottom"></td>
                            <td class="has-border notop nobottom right-align"><b><?php echo e(Utility::formatPrice($sale->delivery_charge)); ?></b></td>
                        </tr>
                        <?php endif; ?>
                        <?php if($sale->estimate->customer->state->id==Utility::STATE_ID_KERALA): ?>
                        <tr class="center" >
                            <td class="has-border notop noright nobottom"></td>
                            <td colspan="3" class="has-border notop noright nobottom right-align"><b>CGST</b></td>
                            <td class="has-border notop noright nobottom"></td>
                            <td class="has-border notop noright nobottom"></td>
                            <td class="has-border notop noright nobottom"></td>
                            <td class="has-border notop noright nobottom"></td>
                            <td class="has-border notop nobottom right-align"><b><?php echo e(Utility::formatPrice($sale->total_igst/2)); ?></b></td>
                        </tr>
                        <tr class="center" >
                            <td class="has-border notop noright nobottom"></td>
                            <td colspan="3" class="has-border notop noright nobottom right-align"><b>SGST</b></td>
                            <td class="has-border notop noright nobottom"></td>
                            <td class="has-border notop noright nobottom"></td>
                            <td class="has-border notop noright nobottom"></td>
                            <td class="has-border notop noright nobottom"></td>
                            <td class="has-border notop nobottom right-align"><b><?php echo e(Utility::formatPrice($sale->total_igst/2)); ?></b></td>
                        </tr>
                        <?php else: ?>
                        <tr class="center" >
                            <td class="has-border notop noright nobottom"></td>
                            <td colspan="3" class="has-border notop noright nobottom right-align"><b>IGST</b></td>
                            <td class="has-border notop noright nobottom"></td>
                            <td class="has-border notop noright nobottom"></td>
                            <td class="has-border notop noright nobottom"></td>
                            <td class="has-border notop noright nobottom"></td>
                            <td class="has-border notop nobottom right-align"><b><?php echo e(Utility::formatPrice($sale->total_igst)); ?></b></td>
                        </tr>
                        <?php endif; ?>
                        <?php if (! (($sale->discount==0))): ?>
                            <tr class="center" >
                                <td class="has-border notop nobottom noright"></td>
                                <td colspan="3" class="has-border notop nobottom noright right-align"><b>Discount</b></td>
                                <td class="has-border notop nobottom noright"></td>
                                <td class="has-border notop nobottom noright"></td>
                                <td class="has-border notop nobottom noright"></td>
                                <td class="has-border notop nobottom noright"></td>
                                <td class="has-border notop nobottom right-align"><b><?php echo e(Utility::formatPrice($sale->discount)); ?></b></td>
                            </tr>
                        <?php endif; ?>
                        <?php if (! (($sale->round_off==0))): ?>
                            <tr class="center" >
                                <td class="has-border notop nobottom noright"></td>
                                <td colspan="3" class="has-border notop nobottom noright right-align"><b>Round Off</b></td>
                                <td class="has-border notop nobottom noright"></td>
                                <td class="has-border notop nobottom noright"></td>
                                <td class="has-border notop nobottom noright"></td>
                                <td class="has-border notop nobottom noright"></td>
                                <td class="has-border notop nobottom right-align"><b><?php echo e(Utility::formatPrice($sale->round_off)); ?></b></td>
                            </tr>
                        <?php endif; ?>

                        <tr class="center height-20" >
                            <td class="has-border noright"></td>
                            <td colspan="3" class="has-border noright right-align vertical-m">Total</td>
                            <td class="has-border noright"></td>
                            <td class="has-border noright vertical-m"><?php echo e($sale->sub_quantity); ?> <?php echo e($product->uom->name); ?></td>
                            <td class="has-border noright"></td>
                            <td class="has-border noright"></td>
                            <td class="has-border vertical-m right-align"><b><?php echo e(Utility::formatPrice($sale->sub_total+$sale->total_igst+$sale->delivery_charge-$sale->round_off-$sale->discount)); ?></b></td>
                        </tr>

                        <tr class="center height-20" >
                            <td colspan="8" class="has-border notop noright left-align"><small>Amount Chargeable (in words)</small><br>
                                <b><?php echo e(Utility::CURRENCY_DISPLAY . ' ' . Utility::currencyToWords(($sale->sub_total+$sale->total_igst+$sale->delivery_charge-$sale->round_off-$sale->discount))); ?></b>
                            </td>
                            <td class="has-border notop noleft right-align">E. & O.E</td>
                        </tr>

                        <?php if($sale->estimate->customer->state->id==Utility::STATE_ID_KERALA): ?>
                            <tr class="center height-20" >
                                <td rowspan="2" colspan="3" class="has-border notop noright vertical-m">HSN/SAC</td>
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
                            <?php $__currentLoopData = $sale->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="center height-20" >
                                <td colspan="3" class="has-border notop noright left-align w-quarter"><?php echo e($product->hsn->name); ?></td>
                                <td class="has-border notop noright"><?php echo e(Utility::formatPrice($product->pivot->price*$product->pivot->quantity)); ?></td>
                                <td class="has-border notop noright"><?php echo e($product->hsn->tax_slab->name/2); ?>%</td>
                                <td class="has-border notop noright"><?php echo e(Utility::formatPrice((($product->pivot->price*$product->pivot->quantity)*($product->hsn->tax_slab->name/100))/2)); ?></td>
                                <td class="has-border notop noright"><?php echo e($product->hsn->tax_slab->name/2); ?>%</td>
                                <td class="has-border notop noright"><?php echo e(Utility::formatPrice((($product->pivot->price*$product->pivot->quantity)*($product->hsn->tax_slab->name/100))/2)); ?></td>
                                <td class="has-border notop"><?php echo e(Utility::formatPrice(($product->pivot->price*$product->pivot->quantity)*($product->hsn->tax_slab->name/100))); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr class="center height-40" >
                                <td colspan="3" class="has-border notop noright right-align  vertical-m w-quarter"><b>Total</b></td>
                                <td class="has-border notop noright  vertical-m"><b><?php echo e(Utility::formatPrice($sale->sub_total)); ?></b></td>
                                <td class="has-border notop noright"></td>
                                <td class="has-border notop noright  vertical-m"><b><?php echo e(Utility::formatPrice($sale->total_sgst)); ?></b></td>
                                <td class="has-border notop noright"></td>
                                <td class="has-border notop  vertical-m"><b><?php echo e(Utility::formatPrice($sale->total_sgst)); ?></b></td>
                                <td class="has-border notop vertical-m"><b><?php echo e(Utility::formatPrice($sale->total_igst)); ?></b></td>
                            </tr>
                        <?php else: ?>
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
                            <?php $__currentLoopData = $sale->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="center height-20" >
                                <td colspan="5" class="has-border notop noright left-align"><?php echo e($product->hsn->name); ?></td>
                                <td class="has-border notop noright"><?php echo e(Utility::formatPrice($product->pivot->price*$product->pivot->quantity)); ?></td>
                                <td class="has-border notop noright"><?php echo e($product->hsn->tax_slab->name); ?>%</td>
                                <td class="has-border notop noright"><?php echo e(Utility::formatPrice(($product->pivot->price*$product->pivot->quantity)*($product->hsn->tax_slab->name/100))); ?></td>
                                <td class="has-border notop"><?php echo e(Utility::formatPrice(($product->pivot->price*$product->pivot->quantity)*($product->hsn->tax_slab->name/100))); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr class="center height-40" >
                                <td colspan="5" class="has-border notop noright right-align  vertical-m"><b>Total</b></td>
                                <td class="has-border notop noright  vertical-m"><b><?php echo e(Utility::formatPrice($sale->sub_total)); ?></b></td>
                                <td class="has-border notop noright"></td>
                                <td class="has-border notop noright  vertical-m"><b><?php echo e(Utility::formatPrice($sale->total_igst)); ?></b></td>
                                <td class="has-border notop  vertical-m"><b><?php echo e(Utility::formatPrice($sale->total_igst)); ?></b></td>
                            </tr>
                        <?php endif; ?>

                        <tr class="center height-20" >
                            <td colspan="9" class="has-border notop left-align"><small>Tax Amount (in words)  : </small><?php echo e(Utility::CURRENCY_DISPLAY . ' ' . Utility::currencyToWords($sale->total_igst)); ?></td>
                        </tr>


                        <tr class="center" >
                            <td colspan="5" class="w-half has-border notop nobottom noright left-align vertical-b">
                                <?php if (! (empty($sale->estimate->customer->pan))): ?><?php echo 'Company\'s PAN: '. $sale->estimate->customer->pan; ?><?php endif; ?>
                            </td>
                            <td colspan="4" class="w-half has-border notop noleft left-align">
                                <?php if(!empty($sale->estimate->branch->bank->name)): ?>
                                Company's Bank Details<br>
                                Bank Name : <?php echo e($sale->estimate->branch->bank->name); ?><br>
                                A/c Name : <?php echo e($sale->estimate->branch->account_name); ?><br>
                                A/c No. : <?php echo e($sale->estimate->branch->account_number); ?><br>
                                Branch & IFS Code: <?php echo e($sale->estimate->branch->bank_branch); ?> & <?php echo e($sale->estimate->branch->ifsc); ?>

                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr class="center" >
                            <td colspan="5" class="w-half has-border notop noright left-align">
                                <u><small>Declaration</small></u><br>
                                We declare that this invoice shows the actual price of the
                                goods described and that all particulars are true and
                                correct.
                            </td>
                            <td colspan="4" class="w-half has-border notop right-align">
                                for <?php echo e(!empty($sale->estimate->branch->trade_name) ? $sale->estimate->branch->trade_name : $sale->estimate->branch->name); ?><br>
                                <br>
                                <br>
                                Authorised Signatory</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer margin-top ">
        <div style="text-align: center">This is a Computer Generated Invoice</div>
        
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\azzet_crm\resources\views\admin\employee\sales\pdf.blade.php ENDPATH**/ ?>