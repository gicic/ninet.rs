<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPeriod extends Model
{
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
