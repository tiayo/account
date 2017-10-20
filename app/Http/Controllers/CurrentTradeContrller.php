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

    /**
     * 根据条件获取
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {
        $volume = $request->get('volume') * 100 ?? 0;

        $symbol = $request->get('symbol') ?? null;

        if (!empty($symbol)) {
            $where = [
                ['volume', '>=', $volume],
                ['symbol', $symbol]
            ];
        } else {
            $where = [
                ['volume', '>=', $volume],
            ];
        }

        $trades = CurTrade::limit(15)
            ->where($where)
            ->orderBy('id', 'desc')
            ->get();

        foreach ($trades as $trade) {
            $json[] = [
                'symbol' => $trade['SYMBOL'],
                'update_time' => $trade['update_time'],
                'type' => $trade['type'],
                'cmd' => $trade['CMD'],
                'open_price' => $trade['OPEN_PRICE'],
                'close_price' => $trade['CLOSE_PRICE'],
                'volume' => $trade['VOLUME']
            ];
        }

        return response()->json(array_reverse($json));
    }
}