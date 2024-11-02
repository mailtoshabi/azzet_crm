<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeReport extends Model
{
    use HasFactory;

    protected $hidden = ['id'];

    protected $guarded = [];

    protected $casts = ['reported_at'=>'date'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

}
