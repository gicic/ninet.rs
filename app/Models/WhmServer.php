<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhmServer extends Model
{
    public function whmPackages()
    {
        return $this->belongsTo(WhmPackage::class);
    }
}
