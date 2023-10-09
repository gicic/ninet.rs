<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function invoicePDF(Request $request, $orderId)
    {
        $order = Order::where('id', $orderId)
            ->with(['currency', 'customer.contacts', 'orderDetails'])
            ->firstOrFail();

        return Invoice::orderToPdf($order);
    }
}
