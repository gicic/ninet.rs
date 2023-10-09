<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolusNode extends Model
{
    public function solusNodeGroup()
    {
        return $this->belongsTo(SolusNodeGroup::class);
    }

    public function solusNodeType()
    {
        return $this->belongsTo(SolusNodeType::class);
    }
}
