<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Executive extends Authenticatable
{
    use HasFactory;
    use LogsActivity;

    const DIR_STORAGE = 'storage/executives/';
    const DIR_PUBLIC = 'executives/';

    protected $hidden = [
        'id',
        'user_id',
        'password'
    ];

    protected $cast = [
        'status' => 'boolean',
    ];

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'phone',
        'building_no',
        'password',
        'street',
        'city',
        'postal_code',
        'district_id',
        'state_id',
        'image',
        'website',
        'status',
        'branch_id'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['id', 'name', 'email', 'email_verified_at', 'phone', 'building_no', 'street', 'city', 'postal_code', 'district_id', 'state_id', 'image', 'website',])
        ->setDescriptionForEvent(fn(string $eventName) => "The Executive has been {$eventName}");
    }

    public function enquiries()
    {
        return $this->hasMany(Enquiry::class);
    }

    public function branch()
    {
        return $this->belongsTO(Branch::class);
    }

    // public function contactPersons()
    // {
    //     return $this->belongsToMany(ContactPerson::class, 'customer_contact_person');
    // }

}
