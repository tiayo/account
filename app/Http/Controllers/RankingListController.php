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

        return ['info' => $info, 'info_reverse' => $info_reverse];
    }

    public function getFollow()
    {
        $info = $this->follow
            ->orderBy('PROFIT_AVG', 'desc')
            ->where('PROFIT_SUM', '>=', 10000)
            ->limit(10)
            ->get()
            ->toArray();

        $info_reverse = $this->follow
            ->orderBy('PROFIT_AVG')
            ->where('PROFIT_SUM', '>=', 10000)
            ->limit(10)
            ->get()
            ->toArray();

        return ['info' => $info, 'info_reverse' => $info_reverse];
    }
}