<?php

namespace App\Http\Controllers;

use App\HoldingSymbol;
use Illuminate\Support\Facades\DB;

class HoldingSymbolController extends Controller
{
    protected  $symbol;
    protected $count;

    public function __construct(HoldingSymbol $symbol)
    {
        $this->symbol = $symbol;
        $this->count = 6;
    }

    public function view()
    {
        $symbols = $this->getSymbol();

        $result = [];$i = 1;

        foreach ($symbols as $symbol) {

            $init_value_0 = $this->getVolume($symbol, 0);

            $init_value_1 = $this->getVolume($symbol, 1);

            $result[$i]['symbol'] = $symbol['SYMBOL'];
 
            $sum = $init_value_0['VOLUME'] + $init_value_1['VOLUME'] ? : 1;

            $result[$i][0]['value'] = number_format($init_value_0['VOLUME'] / $sum * 100, 2);
            $result[$i][1]['value'] = number_format($init_value_1['VOLUME'] / $sum * 100, 2);

            $i++;
        }

        return view('holding_symbol', [
            'init_array' => $result,
            'init_value' => json_encode($result),
            'symbols' => $symbols,
            'count' => $this->count,
        ]);
    }

    /**
     * 获取交易手数
     *
     * @param $symbol
     * @param $cmd
     * @return mixed
     */
    public function getVolume($symbol, $cmd)
    {
        return $this->symbol
            ->select('VOLUME')
            ->where('SYMBOL', $symbol['SYMBOL'])
            ->where('CMD', $cmd)
            ->first();
    }

    /**
     * 获取所有分组
     *
     * @return \Illuminate\Support\Collection
     */
    public function getSymbol()
    {
        return $this->symbol
            ->select('SYMBOL')
            ->groupBy('SYMBOL')
            ->orderBy('VOLUME', 'desc')
            ->get();
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
        $values = $this->symbol
            ->select('VOLUME', 'CMD')
            ->where('SYMBOL', $symbol)
            ->get();

        $sum = 0; $num_0 = 0; $num_1 = 0;
        
        foreach ($values as $value) {

            if ($value['CMD'] == 1) {

                $num_1 = $value['VOLUME'];

            } else if($value['CMD'] == 0) {

                $num_0 = $value['VOLUME'];
            }

            $sum += $value['VOLUME'];
        }

        $result['symbol'] = $symbol;
        $result[0]['value'] = number_format($num_0 / ($sum ? : 1) * 100, 2);
        $result[1]['value'] = number_format($num_1 / ($sum ? : 1) * 100, 2);

        return response()->json($result);
    }
}