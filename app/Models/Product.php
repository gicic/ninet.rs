<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations;

    public $translatable = ['name', 'description'];
    protected $fillable = ['code', 'name', 'description', 'product_line_id', 'price_resident', 'price_foreign', 'quantity_from', 'quantity_to', 'public', 'active'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function discounts()
    {
        return $this->belongsToMany(Discount::class)->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subproducts()
    {
        return $this->belongsToMany(Subproduct::class)->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productLine()
    {
        return $this->belongsTo(ProductLine::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productCharacteristics()
    {
        return $this->hasMany(ProductCharacteristic::class);
    }

    public function solusPlan()
    {
        return $this->hasOne(SolusPlan::class);
    }

    public function whmPackage()
    {
        return $this->hasOne(WhmPackage::class);
    }

    public function domainExtension()
    {
        return $this->hasOne(DomainExtension::class);
    }

    public function sslSecurityLevel()
    {
        return $this->hasOne(SslSecurityLevel::class);
    }

    /**
     * @param string $type [registration, renewal, transfer]
     * @return float
     */
    public function getDomainPrice($type = 'registration')
    {

        $locale = App::getLocale();

        $euro = Currency::find(2);
        $price = null;

        $priceResidentType = $type . '_price_resident';
        $priceForeignType = $type . '_price_foreign';

        $domainExt = $this->domainExtension;

        if(in_array($locale, ['sr', 'sr-Latn'])) {
            if( ! empty($domainExt->$priceResidentType)) {
                $price = $domainExt->$priceResidentType;
            } else if( ! empty($domainExt->$priceForeignType)) {
                $price = $domainExt->$priceForeignType * $euro->latestRate;
            } else if( ! empty($this->price_resident)) {
                $price = $this->price_resident;
            } else {
                $price = $this->price_foreign * $euro->latestRate;
            }
        } else {
            if( ! empty($domainExt->$priceForeignType)) {
                $price = $domainExt->$priceForeignType;
            } else if( ! empty($domainExt->$priceResidentType)) {
                $price = $domainExt->$priceResidentType / $euro->latestRate;
            } else if( ! empty($this->price_foreign)) {
                $price = $this->price_foreign;
            } else {
                $price = $this->price_resident / $euro->latestRate;
            }
        }

        return round($price, 2);
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        $locale = App::getLocale();

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
}
