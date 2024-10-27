<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ContactPerson extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'contact_persons';

    protected $fillable = ['name', 'email', 'phone', 'customer_id','user_id'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['name', 'email', 'phone', 'customer_id','user_id'])
        ->setDescriptionForEvent(fn(string $eventName) => "The Contact Person has been {$eventName}");
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    // public function customer()
    // {
    //     return $this->belongsToMany(customer::class, 'customer_contact_person');
    // }
}
