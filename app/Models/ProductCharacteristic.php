<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ProductCharacteristic extends Model
{
    use HasTranslations;

    public $translatable = ['name', 'description'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
