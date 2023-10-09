<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ProductCategory extends Model
{
    use HasTranslations;

    public $translatable = ['name', 'description'];

    protected $fillable = ['name', 'description'];

    public function productLines()
    {
        return $this->hasMany(ProductLine::class);
    }

    public function orderPeriods()
    {
        return $this->hasMany(OrderPeriod::class);
    }
}
