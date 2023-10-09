<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 10.9.2018.
 * Time: 15:35
 */

namespace App\Services\GoDaddy\Resource;


class Consent
{

    /**
     * Unique identifiers of the legal agreements to which the end-user has agreed, as returned from the/domains/agreements endpoint ,
     * @var array
     */
    public $agreementKeys = [];

    /**
     * Originating client IP address of the end-user's computer when they consented to these legal agreements ,
     * @var null
     */
    public $agreedBy = null;

    /**
     * Timestamp indicating when the end-user consented to these legal agreements
     * @var null
     */
    public $agreedAt = null;

    public function toArray()
    {
        return [
            'agreementKeys' => $this->agreementKeys,
            'agreedBy'      => $this->agreedBy,
            'agreedAt'      => $this->agreedAt,
        ];
    }

}