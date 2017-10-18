<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurTrade extends Model
{
    public $timestamps = false;

    protected $fillable = [];

    protected $connection = 'mysql_ar';
}

