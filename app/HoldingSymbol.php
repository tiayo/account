<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HoldingSymbol extends Model
{
    public $timestamps = false;

    protected $fillable = [];

    protected $table = 'holding_symbol';
}

