<?php

namespace App\Mail;

use App\Models\Internet;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InternetRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $internet = null;
    public $additionalData = null;

    /**
     * Create a new message instance.
     *
     * @param  Internet $internet
     * @param  array $additionalData
     * @return  void
     */
    public function __construct(Internet $internet, $additionalData)
    {
        $this->internet = $internet;
        $this->additionalData = $additionalData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Novi zahtev za besplatno probno merenje: ' . $this->internet->first_name . ' ' . $this->internet->last_name)
            ->markdown('emails.internet-request');
    }
}
