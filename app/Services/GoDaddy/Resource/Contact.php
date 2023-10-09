<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 10.9.2018.
 * Time: 15:07
 */

namespace App\Services\GoDaddy\Resource;


use App\Transliterator;

class Contact
{

    const REGISTRANT = 'contactRegistrant';
    const ADMIN = 'contactAdmin';
    const TECH = 'contactTech';
    const BILLING = 'contactBilling';

    public $nameFirst = null;
    public $nameLast = null;
    public $nameMiddle = null; // optional
    public $organization = null; // optional
    public $jobTitle = null; // optional
    public $email = null;
    public $phone = null;
    public $fax = null; // optional
    public $address1 = null;
    public $address2 = null; // optional
    public $city = null;
    public $state = null;
    public $postalCode = null;
    public $country = null;

    protected $contactType;

    public function __construct($contactType)
    {
        $this->contactType = $contactType;
    }

    public function setContactType($contactType)
    {
        $this->contactType = $contactType;
    }

    public function getContactType()
    {
        return $this->contactType;
    }

    public function toArray()
    {
        $array = [
            'nameFirst'      => Transliterator::srToLat($this->nameFirst),
            'nameLast'       => Transliterator::srToLat($this->nameLast),
            'nameMiddle'     => Transliterator::srToLat($this->nameMiddle),
            'organization'   => Transliterator::srToLat($this->organization),
            'jobTitle'       => Transliterator::srToLat($this->jobTitle),
            'email'          => Transliterator::srToLat($this->email),
            'phone'          => Transliterator::srToLat($this->phone),
            'fax'            => Transliterator::srToLat($this->fax),
            'addressMailing' => [
                'address1'   => Transliterator::srToLat($this->address1),
                'address2'   => Transliterator::srToLat($this->address2),
                'city'       => Transliterator::srToLat($this->city),
                'postalCode' => Transliterator::srToLat($this->postalCode),
                'country'    => Transliterator::srToLat($this->country),
            ],
        ];

        if(isset($this->state)) {
            $array['addressMailing']['state'] = Transliterator::srToLat($this->state);
        }

        $array['addressMailing'] = array_filter($array['addressMailing'], function ($v) {
            return $v !== null;
        });

        $array = array_filter($array, function ($v) {
            return $v !== null;
        });

        return $array;
    }

}