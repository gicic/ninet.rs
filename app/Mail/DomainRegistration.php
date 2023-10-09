<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DomainRegistration extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;

    /**
     * Create a new message instance.
     *
     * @param $mailData
     * @return void
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $markdown = $this->mailData['domainType'] == 'cctld' ? 'emails.rs-domain-registration' : 'emails.com-domain-registration';

        return $this->from('helpdesk@webglobe.rs',  __('company.webglobe'))->subject(__('main.domain_registration'))
            ->markdown($markdown);
    }
}
