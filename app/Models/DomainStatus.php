<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class DomainStatus extends Model
{
    use HasTranslations;

    public $translatable = ['name'];

    /**
     * Domains with given status
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function domains()
    {
        return $this->hasMany(Customer::class);
    }
}
