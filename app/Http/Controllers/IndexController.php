<?php

namespace App\Http\Controllers;

use App\Trade;
use App\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    protected $user;
    protected $request;
    protected $trade;

    public function __construct(Request $request, User $user, Trade $trade)
    {
        $this->user = $user;
        $this->request = $request;
        $this->trade = $trade;
    }

    /**
     * 显示首页
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('index');
    }

    /**
     * 会员数量页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dataStatistics()
    {
        return view('dataStatistics');
    }

    /**
     * 获取user表数据
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        $type = $this->request->get('type');

        if ($type == 1) {
            $user = $this->user
                ->select('EQUITY')
                ->first()
                ->toArray();
        } else if ($type == 2) {
            $user = $this->user
                ->select('USER_CNT', 'MARGIN', 'BALANCE', 'EQUITY', 'TRADE_CNT', 'TRADE_VOL')
                ->first()
                ->toArray();
        }


        return response()->json($user);
    }

    /**
     * 获取trades表数据
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function trades()
    {
        $trades = $this->trade
            ->select('TICKET', 'SYMBOL', 'VOLUME', 'OPEN_TIME', 'CMD', 'LOGIN', 'OPEN_PRICE')
            ->whereIn('CMD', [0,1])
            ->where('SYMBOL', 'not like', '%bo%')
            ->orderBy('OPEN_TIME', 'desc')
            ->limit(10)
            ->get()
            ->toArray();

        $trades_handle = [];

        //屏蔽关键字段
        foreach ($trades as $trade) {

            $trade['TICKET'] = substr_replace($trade['TICKET'], '****', 0, strlen($trade['TICKET'])-2);

            $trade['LOGIN'] = substr_replace($trade['LOGIN'], '****', 0, strlen($trade['LOGIN'])-2);

            $trades_handle[] = $trade;
        }

        return response()->json($trades_handle);
    }
}