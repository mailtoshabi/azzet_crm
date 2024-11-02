<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Estimate extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id','user_id','enquiry_id','branch_id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('id','quantity','profit')->withTimestamps();
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function enquiry(): BelongsTo
    {
        return $this->belongsTo(Enquiry::class);
    }

    public function sale(): HasOne
    {
        return $this->hasOne(Sale::class);
    }

    public function getsubTotalAttribute() {
        $total = 0;
        foreach($this->products as $product) {
            $profit = $product->pivot->profit;
            $quantity = $product->pivot->quantity;
            $sum_price_components = DB::table('component_estimate_product')->where('estimate_product_id',$product->pivot->id)->sum('cost');
            $price = $profit + $sum_price_components;
            $total += $quantity*$price;
        }
        return $total;
    }

    public function branch()
    {
        return $this->belongsTO(Branch::class);
    }

    public function user()
    {
        return $this->belongsTO(User::class);
    }

}
