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
        'is_approved' => 'boolean',
    ];
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['id', 'name', 'email', 'phone', 'city', 'postal_code', 'district_id', 'state_id', 'image', 'website',])
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function branch()
    {
        return $this->belongsTO(Branch::class);
    }

}
