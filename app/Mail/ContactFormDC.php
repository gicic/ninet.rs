<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactFormDC extends Mailable
{
    use Queueable, SerializesModels;

    public $data = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->from('helpdesk@webglobe.rs',  __('company.webglobe'))->subject('Kontakt forma - Webglobe ')
            ->markdown('emails.contact-form');

        if(!empty($this->data['documents'])) {
            foreach($this->data['documents'] as $document) {
                $email->attach($document->getRealPath(), [
                    'as' => $document->getClientOriginalName(),
                    'mime' => $document->getClientMimeType(),
                ]);
            }
        }

        return $email;
    }
}
