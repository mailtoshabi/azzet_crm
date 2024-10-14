<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Executive extends Model
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
        ->logOnly(['id', 'name', 'email', 'email_verified_at', 'phone', 'building_no', 'street', 'city', 'postal_code', 'district_id', 'state_id', 'image', 'website',])
        ->setDescriptionForEvent(fn(string $eventName) => "The Executive has been {$eventName}");
    }

    public function enquiries()
    {
        return $this->hasMany(Enquiry::class);
    }

    // public function contactPersons()
    // {
    //     return $this->belongsToMany(ContactPerson::class, 'customer_contact_person');
    // }

}
