<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Internet extends Model
{
    protected $connection = 'mysql_old';
    protected $table = 'internet';
    protected $primaryKey = 'id';

    public $timestamps = false;

    public function proizvod()
    {
        return $this->belongsTo(Proizvodi::class, 'id_proizvod', 'id_proizvodi');
    }
}
