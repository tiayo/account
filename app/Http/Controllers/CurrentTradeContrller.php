<?php

namespace App\Http\Controllers;

use App\CurTrade;

class CurrentTradeContrller extends Controller
{
    public function index()
    {
        $trades = CurTrade::limit(15)->orderBy('id', 'desc')->get();

        return view('current_trade', [
            'trades' => $trades,
        ]);
    }
}