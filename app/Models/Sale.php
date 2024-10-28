<?php

namespace App\Models;

use App\Http\Utilities\Utility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    use HasFactory;

    protected $hidden = ['id'];

    protected $guarded = [];

    protected $casts = ['date_confirmed' => 'datetime','date_production' => 'datetime','date_out_delivery' => 'datetime','date_delivered' => 'datetime','date_closed' => 'datetime','date_onhold' => 'datetime','date_cancelled' => 'datetime'];

    public function customer()
    {
        return $this->belongsTO(Customer::class);
    }

    public function products() {
        return $this->belongsToMany(Product::class,'product_sale')->withPivot('id','price','quantity','gst_id')->withTimestamps();
    }

    public function getPaymentMethodTextAttribute() {
        if($this->pay_method==Utility::PAYMENT_ONLINE) return '<i class="fab fa-cc-visa me-1"></i> Online Payment';
        else if($this->pay_method==Utility::PAYMENT_COD) return '<i class="fas fa-money-bill-alt me-1"></i> Cash On Delivery';
        else return '-';
    }

    public function scopeActive($query) {
        return $query->where('status',Utility::ITEM_ACTIVE);
    }

    public function scopeArchive($query) {
        return $query->where('status',Utility::ITEM_INACTIVE);
    }

    public function estimate(): BelongsTo
    {
        return $this->belongsTo(Estimate::class);
    }

    public function getsubTotalAttribute() {
        $total = 0;
        foreach($this->products as $product) {

            $quantity = $product->pivot->quantity;
            $price = $product->pivot->price;

            // $price = $profit + $sum_price_components;
            $total += $quantity*$price;
        }
        return $total;
    }

    public function getsubQuantityAttribute() {
        $total = 0;
        foreach($this->products as $product) {

            $quantity = $product->pivot->quantity;

            // $price = $profit + $sum_price_components;
            $total += $quantity;
        }
        return $total;
    }

    public function getTotalIgstAttribute() {
        $gst = 0;
        foreach($this->products as $product) {
            $gst_perc = $product->hsn->tax_slab->name;
            $quantity = $product->pivot->quantity;
            $price = $product->pivot->price;
            $product_price = $quantity*$price;
            $gst += $product_price*($gst_perc/100);
        }
        return $gst;
    }

    public function getTotalSgstAttribute() {
        $gst = 0;
        foreach($this->products as $product) {
            $gst_perc = $product->hsn->tax_slab->name;
            $quantity = $product->pivot->quantity;
            $price = $product->pivot->price;
            $product_price = $quantity*$price;
            $gst += $product_price*($gst_perc/100);
        }
        return $gst/2;
    }

    // public function branch()
    // {
    //     return $this->belongsTO(Branch::class);
    // }

    // public function executive()
    // {
    //     return $this->belongsTo(Executive::class);
    // }

}
