<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhmPackage extends Model
{

    protected $fillable = ['name', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function whmServer()
    {
        return $this->belongsTo(WhmServer::class);
    }
}
