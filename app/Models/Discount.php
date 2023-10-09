<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Discount extends Model
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function discountType()
    {
        return $this->belongsTo(DiscountType::class);
    }

    public function currency() : BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function discountOrderPeriods() : HasMany
    {
        return $this->hasMany(DiscountOrderPeriod::class);
    }

}
