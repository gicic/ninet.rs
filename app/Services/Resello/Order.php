<?php

namespace App\Services\Resello;

class Order extends ResourceWrapper
{
    protected $paths = array(
        'collection' => '/order',
    );

    /**
     * @param $customer
     * @param $domain
     * @return mixed
     * @throws HostControlAPIClientError
     */
    public function order_domain($customer, $domain)
    {
        return $this->apiclient->post($this->get_request_path('collection'), array(
            'customer' => intval($customer),
            'type' => 'new',
            'order' => array(
                array(
                    'type' => 'domain-register-order',
                    'name' => $domain,
                    'interval' => 12,
                )
            )
        ));
    }

}
