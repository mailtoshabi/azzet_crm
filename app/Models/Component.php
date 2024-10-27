<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Component extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $fillable = ['name', 'cost','user_id'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['name', 'cost','user_id'])
        ->setDescriptionForEvent(fn(string $eventName) => "The Component has been {$eventName}");
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('id','cost','o_cost')->withTimestamps();
    }
}
