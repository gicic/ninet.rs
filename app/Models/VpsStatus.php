<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class VpsStatus extends Model
{
    use HasTranslations;

    public $translatable = ['name'];

    public function virtualPrivateServers()
    {
        return $this->hasMany(VpsResource::class);
    }
}
