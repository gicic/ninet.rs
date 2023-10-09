<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolusNodeGroup extends Model
{
    public function solusNodes()
    {
        return $this->hasMany(SolusNode::class);
    }
}
