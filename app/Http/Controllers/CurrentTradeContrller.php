<?php

namespace App\Http\Controllers;

use App\CurTrade;
use Carbon\Carbon;
use function foo\func;
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
        $json = [];

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

    /**
     * 统计单子分布
     *
     * @param Request $reques
     * @return \Illuminate\Http\JsonResponse
     */
    public function account(Request $reques)
    {
        $result_1 = $this->accountHandle(1, $reques);
        $result_0 = $this->accountHandle(0, $reques);

        return response()->json([
            0 => $result_0,
            1 => $result_1,
        ]);
    }

    /**
     * 计算和处理
     *
     * @param $type
     * @param Request $reques
     * @return array
     */
    public function accountHandle($type, Request $reques)
    {
        $data = $reques->all();

        $min = !empty($data['account_min'] * 100) ? $data['account_min'] * 100 : 100;
        $max = !empty($data['account_max'] * 100) ? $data['account_max'] * 100 : 1000;
        $before = !empty($data['account_before']) ? Carbon::now()->addHour(0 - $reques->get('account_before')) : 0;
        $symbol = !empty($data['subscribe_symbol']) ? $data['subscribe_symbol'] : 0;

        //小单
        $where_1[] = ['VOLUME', '<', $min];
        !empty($before) ? $where_1[] = ['update_time', '>', $before] : true;
        !empty($symbol) ? $where_1[] = ['SYMBOL', $symbol] : true;
        $count_1 = $this->count($where_1, $type);

        //中单
        $where_2[] = ['VOLUME', '>=', $min];
        $where_2[] = ['VOLUME', '<=', $max];
        !empty($before) ? $where_2[] = ['update_time', '>', $before] : true;
        !empty($symbol) ? $where_2[] = ['SYMBOL', $symbol] : true;
        $count_2 = $this->count($where_2, $type);

        //大单
        $where_3[] = ['VOLUME', '>', $max];
        !empty($before) ? $where_3[] = ['update_time', '>', $before] : true;
        !empty($symbol) ? $where_3[] = ['SYMBOL', $symbol] : true;
        $count_3 = $this->count($where_3, $type);

        //总数
        $count = $count_1 + $count_2 + $count_3 != 0 ?
            $count_1 + $count_2 + $count_3 : 1;

        return [
            1 => (int) $count_1 / $count * 100,
            2 => (int) $count_2 / $count * 100,
            3 => (int) $count_3 / $count * 100,
        ];
    }

    /**
     * 根据条件统计
     *
     * @param $where
     * @param $type
     * @return int
     */
    public function count($where, $type)
    {
        //多头
        if ($type == 0) {
            return CurTrade::where($where)
                ->where(function ($query) {
                    $query->where(function ($query_2) {
                        $query_2->where('type', 1)
                            ->where('CMD', 1);
                    })->orwhere(function ($query_3) {
                        $query_3->where('type', 0)
                            ->where('CMD', 0);
                    });
                })
                ->sum('VOLUME');
        }

        //空头
        return CurTrade::where($where)
            ->where(function ($query) {
                $query->where(function ($query_2) {
                    $query_2->where('type', 1)
                        ->where('CMD', 0);
                })->orwhere(function ($query_3) {
                    $query_3->where('type', 0)
                        ->where('CMD', 1);
                });
            })
            ->sum('VOLUME');
    }
}