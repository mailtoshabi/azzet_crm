<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Employee extends Authenticatable
{
    use HasFactory;
    use LogsActivity;

    const DIR_STORAGE = 'storage/employees/';
    const DIR_PUBLIC = 'employees/';

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
        ->setDescriptionForEvent(fn(string $eventName) => "The Employee has been {$eventName}");
    }

    public function enquiries()
    {
        return $this->hasMany(Enquiry::class);
    }

    public function branch()
    {
        return $this->belongsTO(Branch::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function employee_reports()
    {
        return $this->hasMany(Sale::class);
    }

    // public function contactPersons()
    // {
    //     return $this->belongsToMany(ContactPerson::class, 'customer_contact_person');
    // }

}
