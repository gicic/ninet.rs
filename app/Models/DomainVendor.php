<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DomainVendor extends Model
{
    protected $fillable = ['name'];

    public function registrationExtensions()
    {
        return $this->hasMany(DomainExtension::class, 'registration_vendor_id');
    }

    public function renewalExtension()
    {
        return $this->hasMany(DomainExtension::class, 'renewal_vendor_id');
    }

    public function transferExtension()
    {
        return $this->hasMany(DomainExtension::class, 'transfer_vendor_id');
    }
}
