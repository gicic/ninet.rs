<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Subproduct extends Model
{
    use HasTranslations;

    public $translatable = ['name', 'description'];

    protected $fillable = ['code', 'name', 'description', 'product_line_id', 'price_resident', 'price_foreign', 'quantity_from', 'quantity_to', 'public', 'active'];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }

    public function getPrice()
    {
        $locale = \App::getLocale();

        $euro = Currency::find(2);

        $price = null;
        if(in_array($locale, ['sr', 'sr-Latn'])) {
            if( ! empty($this->price_resident)) {
                $price = $this->price_resident;
            } else if( ! empty($this->price_foreign)) {
                $price = $this->price_foreign * $euro->latestRate;
            }
        } else {
            if( ! empty($this->price_foreign)) {
                $price = $this->price_foreign;
            } else if( ! empty($this->price_resident)){
                $price = $this->price_resident / $euro->latestRate;
            }
        }

        return round($price, 2);
    }

    public function productLine()
    {
        return $this->belongsTo(ProductLine::class);
    }
}
