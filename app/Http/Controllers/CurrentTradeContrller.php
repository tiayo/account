<?php

namespace App\Http\Controllers;

use App\CurTrade;
use Illuminate\Http\Request;

class CurrentTradeContrller extends Controller
{
    public function index(Request $request)
    {
        //获取初始化信息
        $trades = CurTrade::limit(15)->orderBy('id', 'desc')->get();

        //记录session
        $request->session()->put('wsSecret', '1');

        return view('current_trade', [
            'trades' => $trades,
        ]);
    }
}