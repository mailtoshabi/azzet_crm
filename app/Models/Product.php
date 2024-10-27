<?php

namespace App\Models;

use App\Http\Utilities\Utility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Product extends Model
{
    use HasFactory;
    use LogsActivity;

    const DIR_STORAGE = 'storage/products/';
    const DIR_PUBLIC = 'products/';

    protected $hidden = ['id'];

    protected $guarded = [];

    protected $casts = ['status'=>'boolean', 'is_approved'=>'boolean', 'images' => 'array'];

    /**
     * Boot the model.
     */

     public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['id', 'name'])
        ->setDescriptionForEvent(fn(string $eventName) => "The Product has been {$eventName}");
    }

    public function scopeActive($query) {
        return $query->where('status',Utility::ITEM_ACTIVE);
    }

    public function scopeOldestById($query) {
        return $query->orderBy('id', 'asc');
    }

    // public function components()
    // {
    //     return $this->hasMany(Component::class);
    // }

    public function components()
    {
        return $this->belongsToMany(Component::class)->withPivot('id','cost','o_cost')->withTimestamps();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function enquiries()
    {
        return $this->belongsToMany(Enquiry::class)->withPivot('id','quantity')->withTimestamps();
    }

    public function estimates()
    {
        return $this->belongsToMany(Estimate::class)->withPivot('id','quantity','profit')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function executive()
    {
        return $this->belongsTo(Executive::class);
    }

    public function uom()
    {
        return $this->belongsTo(Uom::class);
    }

    public function hsn()
    {
        return $this->belongsTo(Hsn::class);
    }

    public function branch()
    {
        return $this->belongsTO(Branch::class);
    }
}
