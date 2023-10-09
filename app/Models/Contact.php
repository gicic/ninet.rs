<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['contact_type_id', 'first_name', 'last_name', 'is_legal_entity', 'address', 'postal_code', 'city', 'country_id', 'state', 'phone', 'email', 'company_name', 'company_tax_number', 'company_registration_number'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function contactType()
    {
        return $this->belongsTo(ContactType::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Is domestic contact?
     *
     * @return bool
     */
    public function isDomestic(): bool
    {
        return $this->country->code === 'RS';
    }

    public function validator($data)
    {
        $v = \Validator::make($data, [
            'status_id' => 'required|integer|exists:statuses,id',
            'origin_id' => 'required|integer|exists:origins,id',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'date_format:Y-m-d',
        ]);

        return $v;
    }
}
