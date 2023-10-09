<?php

namespace App\Models;

use App\QueryFilter;
use Illuminate\Database\Eloquent\Model;

class DomainResource extends Model
{
    /**
     * Domain status
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(DomainStatus::class, 'domain_status_id');
    }

    /**
     * Domain's vendor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vendor()
    {
        return $this->belongsTo(DomainVendor::class, 'domain_vendor_id');
    }

    /**
     * Domain's active order
     *
     * @return mixed
     */
    public function getActiveOrderAttribute()
    {
        $orderDetails = OrderDetail::where('resource_model', 'App\Models\DomainResource')
            ->where('resource_model_id', $this->id)
            ->orderBy('created_at', 'desc')
            ->first();

        return ['order' => Order::find($orderDetails['order_id']), 'orderDetails' => $orderDetails];
    }

    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }
}
