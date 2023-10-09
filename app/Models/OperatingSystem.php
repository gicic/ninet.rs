<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperatingSystem extends Model
{
    protected $fillable = ['name'];

    public function productLines()
    {
        return $this->belongsToMany(ProductLine::class)->withTimestamps();
    }
}
