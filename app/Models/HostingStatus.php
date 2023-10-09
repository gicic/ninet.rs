<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class HostingStatus extends Model
{
    use HasTranslations;

    public $translatable = ['name'];
}
