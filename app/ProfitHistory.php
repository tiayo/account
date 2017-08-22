<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfitHistory extends Model
{
    public $timestamps = false;

    protected $fillable = [];

    protected $table = 'profit_history';
}

