<?php

namespace App\Mail;

use App\Invoice;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PreInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('helpdesk@webglobe.rs',  __('company.webglobe'))->subject(__('company.webglobe'))
            ->attachData(Invoice::orderToPdf($this->order), 'invoice-' . $this->order->order_number . '.pdf', [
            'mime' => 'application/pdf'
        ])
        ->markdown('emails.pre-invoice');
    }
}
