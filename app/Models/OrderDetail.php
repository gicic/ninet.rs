<?php

namespace App\Models;

use App\Traits\BindableModel;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{

    use BindableModel;

    protected $fillable = ['description', 'price', 'quantity', 'model_type', 'model_id', 'parameters', 'resource_id', 'period_months', 'item_number', 'discount_percentage'];

    /**
     * Order relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function isYearlyItem()
    {
        if(in_array($this->getBoundModel()->productLine->productCategory->code, ['domains', 'hosting', 'ssl'])) {
            return true;
        }
        return false;
    }

    /**
     * Detail total price
     *
     * @return float
     */
    public function totalPrice()
    {
        return round($this->price, 2);
    }

    public function getCategory()
    {
        $model = $this->getBoundModel();
        return $model->productLine->productCategory;
    }

    public function getBoundModel()
    {
        return (new $this->model_type)->where('id', $this->model_id)->with('productLine.productCategory')->first();
    }

    public function taxBase()
    {
        $total = $this->totalPrice();
        $tax = config('general-data.tax');
        $taxBase = $total / (1 + $tax / 100);

        return round($taxBase, 2);
    }

    public function taxAmount()
    {
        return round(($this->totalPrice() - $this->taxBase()), 2);
    }

    public function discountAmount()
    {
        $discount = $this->price * (1 / (1 - $this->discount_percentage / 100) - 1);
        return round($discount, 2);
    }

    public function originalAmount()
    {
        $price = $this->price / (1 - $this->discount_percentage / 100);
        return round($price, 2);
    }

    public function getResourceRow()
    {
        if(empty($this->resource_model)) {
            return null;
        }

        $model = new $this->resource_model;

        $resource = $model->find($this->resource_model_id);

        if($resource instanceof $this->resource_model) {
            return $resource;
        }
        return null;
    }

    public function hasResource()
    {
        return !empty($this->getResourceRow());
    }

}
