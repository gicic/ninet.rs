<?php

namespace App\Mail;

use App\Invoice;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NestpayNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected $theme = 'nestpay-notification';

    public $data;
    public $order;
    public $title;
    public $contact;
    /**
     * Create a new message instance.
     *
     * @param $data
     * @param Order $order
     * @param bool $success
     * @return void
     */
    public function __construct($data, Order $order, $success = true)
    {
        $this->data = $data;
        $this->order = $order;
        $this->contact = $order->customer->getMainContact();

        if(\App::getLocale() === 'sr-Latn') {
            if($success) {
                $this->title = 'Vaša uplata je uspešno izvršena';
            } else {
                $this->title = 'Neuspešna uplata - račun vaše kartice nije zadužen';
            }
        } else {
            if($success) {
                $this->title = 'Your payment has been successfully completed';
            } else {
                $this->title = 'Failed payment';
            }
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('helpdesk@webglobe.rs',  __('company.webglobe'))->subject(__('company.webglobe') . ' - ' . __('main.payment_notification'))
            ->markdown('emails.nestpay-notification');
    }
}
