<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolusNodeType extends Model
{
    public function solusNodes()
    {
        return $this->hasMany(SolusNode::class);
    }
}
