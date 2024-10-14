<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'cost','user_id'];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('id','cost','o_cost')->withTimestamps();
    }
}
