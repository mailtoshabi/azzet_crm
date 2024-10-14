<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Estimate extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id','user_id','enquiry_id'];

    public function executive()
    {
        return $this->belongsTo(Executive::class);
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


}
