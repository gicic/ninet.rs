<?php

namespace App\Mail;

use App\Models\Customer;
use App\Services\OneTimeSecret\Facade\OTS;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MyNinetAccessParameters extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $otsUrl;
    public $mainContact;

    /**
     * Create a new message instance.
     *
     * @param Customer $customer
     * @param string $password
     * @return void
     */
    public function __construct(Customer $customer, $password)
    {
        $this->customer = $customer;
        $this->otsUrl = $password;
        $this->mainContact = $customer->contacts()->where('contact_type_id', 1)->first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('helpdesk@webglobe.rs',  __('company.webglobe'))->subject(__('main.my_ninet_access_parameters'))
            ->markdown('emails.my_ninet_access_parameters');
    }
}
