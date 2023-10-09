<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proizvodi extends Model
{
    protected $connection = 'mysql_old';
    protected $table = 'proizvodi';
    protected $primaryKey = 'id_proizvodi';
}
