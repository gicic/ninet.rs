<?php
/**
 * Created by PhpStorm.
 * User: NINET-17
 * Date: 7.9.2018.
 * Time: 15:31
 */

namespace App;


use App\Models\Order;

class Invoice
{
    public static function orderToPdf(Order $order)
    {
        $pdf = \PDF::loadView('pdf.order.invoice', compact('order'));
        return $pdf->stream();
    }
}