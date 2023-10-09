<?php

namespace App\Models;

use App\QueryFilter;
use Illuminate\Database\Eloquent\Model;

class VpsResource extends Model
{
    /**
     * Virtual private server's status
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(VpsStatus::class, 'vps_status_id');
    }

    /**
     * Virtual private server's node
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function node()
    {
        return $this->belongsTo(SolusNode::class, 'solus_node_id');
    }

    /**
     * Active order
     *
     * @return array
     */
    public function getActiveOrderAttribute()
    {
        $orderDetails = OrderDetail::where('resource_model', 'App\Models\VpsResource')
            ->where('resource_model_id', $this->id)
            ->orderBy('created_at', 'desc')
            ->first();

        return ['order' => Order::find($orderDetails['order_id']), 'orderDetails' => $orderDetails];
    }

    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }

    public static function rules()
    {
        return [
            "hostname" => "required|string|between:6,15",
        ];
    }

    public static function messages()
    {
        return [
            'hostname.required' => trans('virtual_private_servers.hostname_is_required'),
            'hostname.string' => trans('virtual_private_servers.hostname_is_not_string'),
            'hostname.between' => trans('virtual_private_servers.hostname_id_out_of_range'),
        ];
    }

}
