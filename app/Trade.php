<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    public $timestamps = false;

    protected $fillable = [];

    protected $connection = 'mysql_mt4';
}

