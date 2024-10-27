<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hsn extends Model
{
    use HasFactory;

    protected $hidden = ['id'];

    protected $guarded = [];

    public function tax_slab()
    {
        return $this->belongsTo(TaxSlab::class);
    }


}
