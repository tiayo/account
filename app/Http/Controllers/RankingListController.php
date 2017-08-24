<?php

namespace App\Http\Controllers;

use App\Follow;
use App\WinRate;

class RankingListController extends Controller
{
    protected $win_rate;
    protected $follow;

    public function __construct(WinRate $win_rate, Follow $follow)
    {
        $this->win_rate = $win_rate;
        $this->follow = $follow;
    }

    public function view()
    {
        return view('ranking_list', [
            'all_win_rate' => $this->getWinRate(),
            'all_follow' => $this->getFollow(),
        ]);
    }

    public function getWinRate()
    {
        $info = $this->win_rate
            ->orderBy('WIN_RATE', 'desc')
            ->limit(10)
            ->get()
            ->toArray();

        $info_reverse = $this->win_rate
            ->orderBy('WIN_RATE')
            ->limit(10)
            ->get()
            ->toArray();

        return ['info' => $this->handle($info), 'info_reverse' => $this->handle($info_reverse)];
    }

    public function getFollow()
    {
        $info = $this->follow
            ->orderBy('PROFIT_AVG', 'desc')
            ->where('PROFIT_SUM', '>=', 100000)
            ->limit(20)
            ->get()
            ->toArray();

        $info_reverse = $this->follow
            ->orderBy('PROFIT_AVG')
            ->where('PROFIT_AVG', '<=', -100)
            ->limit(20)
            ->get()
            ->toArray();

        return ['info' => $this->handle($info), 'info_reverse' => $this->handle($info_reverse)];
    }

    /**
     * 屏蔽关键字
     *
     * @param $data
     * @return array
     */
    public function handle($data)
    {
        $result = [];

        foreach ($data as $value) {

            $value['NAME'] =  mb_substr($value['NAME'], 0, 1, 'utf8').'***';

            $value['LOGIN_S'] = $value['LOGIN'];

            $value['LOGIN'] = substr_replace($value['LOGIN'], '****', 0, strlen($value['LOGIN'])-2);

            $result[] = $value;
        }

        return $result;
    }
}