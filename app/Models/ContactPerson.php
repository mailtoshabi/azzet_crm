<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactPerson extends Model
{
    use HasFactory;

    protected $table = 'contact_persons';

    protected $fillable = ['name', 'email', 'phone', 'customer_id','user_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    // public function customer()
    // {
    //     return $this->belongsToMany(customer::class, 'customer_contact_person');
    // }
}
