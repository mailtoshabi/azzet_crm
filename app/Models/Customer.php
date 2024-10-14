<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;
    use LogsActivity;

    const DIR_STORAGE = 'storage/customers/';
    const DIR_PUBLIC = 'customers/';

    protected $hidden = [
        'id',
        'user_id'
    ];

    protected $cast = [
        'status' => 'boolean',
    ];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'building_no',
        'street',
        'city',
        'postal_code',
        'district_id',
        'state_id',
        'image',
        'website',
        'status'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['id', 'name', 'email', 'phone', 'building_no', 'street', 'city', 'postal_code', 'district_id', 'state_id', 'image', 'website',])
        ->setDescriptionForEvent(fn(string $eventName) => "The Customer has been {$eventName}");
    }

    public function contactPersons()
    {
        return $this->hasMany(ContactPerson::class);
    }

    // public function contactPersons()
    // {
    //     return $this->belongsToMany(ContactPerson::class, 'customer_contact_person');
    // }

    public function enquiries(): HasMany
    {
        return $this->hasMany(Enquiry::class);
    }

    public function estimates(): HasMany
    {
        return $this->hasMany(Enquiry::class);
    }

}
