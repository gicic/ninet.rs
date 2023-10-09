<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class ProductLine extends Model
{
    use HasTranslations;

    public $translatable = ['name', 'description'];

    protected $fillable = ['product_category_id', 'name', 'description'];

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function operatingSystems()
    {
        return $this->belongsToMany(OperatingSystem::class)->withTimestamps();
    }

    public function orderPeriods() : HasMany
    {
        return $this->hasMany(OrderPeriod::class, 'product_line_id');
    }
}
