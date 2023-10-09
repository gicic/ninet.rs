<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiscountOrderPeriod extends Model
{

    public function discount() : BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }

}
