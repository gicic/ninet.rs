<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DomainExtension extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function registrationVendor()
    {
        return $this->belongsTo(DomainVendor::class, 'registration_vendor_id');
    }

    public function renewalVendor()
    {
        return $this->belongsTo(DomainVendor::class, 'renewal_vendor_id');
    }

    public function transferVendor()
    {
        return $this->belongsTo(DomainVendor::class, 'transfer_vendor_id');
    }

    public function getPriceByPeriod(int $period) : float
    {
        $columnPrefix = \App::getLocale() === 'sr-Latn' ? 'registration_price_resident' : 'registration_price_foreign';

        $price = null;
        if($period == 1) {
            $price = $this->$columnPrefix;
        } else if ($period == 2) {
            $price = $this->{$columnPrefix . '_2'};
        } else if ($period >= 3) {
            $price = $this->{$columnPrefix . '_3'};
        }

        if(empty($price)) {
            $price = $this->product->getPrice();
        }

        return $price;
    }
}
