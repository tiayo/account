<?php

namespace App\Http\Controllers;

use App\HoldingCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HoldingCostController extends Controller
{
    protected $request;
    protected $cost;

    public function __construct(Request $request, HoldingCost $cost)
    {
        $this->request = $request;
        $this->cost = $cost;
    }


    public function view()
    {
        $symbols = $this->getSymbol();

        $type[0] = '多头持仓成本分布图';
        $type[1] = '空头持仓成本分布图';
        $type[2] = '多头止损位分布图';
        $type[3] = '空头止损位分布图';
        $type[4] = '多头止盈位分布图';
        $type[5] = '空头止盈位分布图';

        return view('holding_cost', [
            'type' => $type,
            'symbols' => $symbols,
        ]);
    }

    /**
     * 获取所有分组
     *
     * @return mixed
     */
    public function getSymbol()
    {
        $symbols = $this->cost
            ->select('SYMBOL', DB::raw('count(1) as count'))
            ->groupBy('SYMBOL')
            ->orderBy('count', 'desc')
            ->get();

        return $symbols;
    }

    /**
     * 获取需要的值
     *
     * @param $symbol
     * @param $cmd
     * @param $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function getValue($symbol)
    {
        $values[0] = $this->get($symbol, 0, 0);
        $values[1] = $this->get($symbol, 1, 0);
        $values[2] = $this->get($symbol, 0, 1);
        $values[3] = $this->get($symbol, 1, 1);
        $values[4] = $this->get($symbol, 0, 2);
        $values[5] = $this->get($symbol, 1, 2);

        return response()->json($values);
    }

    /**
     * 数据库取需要的值
     *
     * @param $symbol
     * @param $cmd
     * @param $type
     * @return array
     */
    public function get($symbol, $cmd, $type)
    {
        return $this->cost
            ->select('PRICE', DB::raw('VOLUME / 100 as VOLUME'))
            ->where('SYMBOL', $symbol)
            ->where('CMD', $cmd)
            ->where('TYPE', $type)
            ->get()
            ->toArray();
    }
}