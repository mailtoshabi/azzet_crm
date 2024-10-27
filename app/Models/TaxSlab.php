<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxSlab extends Model
{
    use HasFactory;

    protected $hidden = ['id'];

    protected $guarded = [];

    public function hsns()
    {
        return $this->hasMany(Hsn::class);
    }

    public function getNameAttribute() {
        return $this->name_tax;
    }
}
