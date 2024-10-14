<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Enquiry extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function executive()
    {
        return $this->belongsTo(Executive::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('id','quantity')->withTimestamps();
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function estimate(): HasOne
    {
        return $this->hasOne(Estimate::class);
    }


}
