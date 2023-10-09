<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 16.8.2018.
 * Time: 11:43
 */

namespace App\ShoppingCart;


use App\Models\Country;
use App\Models\Customer;
use Illuminate\Support\Facades\Session;

class CartContact
{

    public $customerId = null;

    public $firstName;
    public $lastName;
    public $companyName;
    public $companyRegistrationNumber;
    public $companyTaxNumber;
    public $address;
    public $postalCode;
    public $city;
    public $countryId;
    public $countryName;
    public $countryCode;
    public $phone;
    public $state;
    public $email;

    /**
     * @param array $attributes
     */
    public function set(array $attributes = [])
    {
        if(empty($attributes['customerId'])) {
            $this->customerId = null;
            $this->firstName = array_get($attributes, 'first_name', $this->firstName);
            $this->lastName = array_get($attributes, 'last_name', $this->lastName);
            $this->companyName = array_get($attributes, 'company_name', $this->companyName);
            $this->companyRegistrationNumber = array_get($attributes, 'company_registration_number', $this->companyRegistrationNumber);
            $this->companyTaxNumber = array_get($attributes, 'company_tax_number', $this->companyTaxNumber);
            $this->address = array_get($attributes, 'address', $this->address);
            $this->postalCode = array_get($attributes, 'postal_code', $this->postalCode);
            $this->city = array_get($attributes, 'city', $this->city);
            $this->countryId = array_get($attributes, 'country_id', $this->countryId);
            $country = Country::find($this->countryId ?? 157);
            $this->countryName = $country->name;
            $this->countryCode = $country->code;

            $dialCode = $country->dial_code;
            $phoneNumber = $attributes['phone'];

            $this->state = array_get($attributes, 'state', $this->state);
            $this->phone = $dialCode . '.' . $phoneNumber;
            $this->email = array_get($attributes, 'email', $this->email);
        } else {
            $this->customerId = $attributes['customerId'];
            $customerDB = Customer::find($this->customerId);
            $contactDB = $customerDB->contacts()->where('contact_type_id', 1)->first();
            $this->firstName = $contactDB->first_name;
            $this->lastName = $contactDB->last_name;
            $this->companyName = $contactDB->company_name;
            $this->companyRegistrationNumber = $contactDB->comapany_registration_number;
            $this->companyTaxNumber = $contactDB->comapny_tax_number;
            $this->address = $contactDB->address;
            $this->postalCode = $contactDB->postal_code;
            $this->city = $contactDB->city;
            $this->countryId = $contactDB->country_id;
            $country = Country::find($this->countryId ?? 157);
            $this->countryName = $country->name;
            $this->countryCode = $country->code;
            $this->state = $contactDB->state;
            $this->phone = $contactDB->phone;
            $this->email = $contactDB->email;
        }
        Session::put('cart_contact_data', $this);
    }

    /**
     * @return CartContact|mixed
     */
    public function get()
    {
        return Session::has('cart_contact_data') ? Session::get('cart_contact_data') : $this;
    }

}