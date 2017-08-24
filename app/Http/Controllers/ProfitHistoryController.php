<?php

namespace App\Http\Controllers;

use App\ProfitHistory;
use Carbon\Carbon;

class ProfitHistoryController extends Controller
{
    protected  $profit_history;

    public function __construct(ProfitHistory $profit_history)
    {
        $this->profit_history = $profit_history;
    }

    public function view($login)
    {
        $login = decrypt($login);

        return view('profit_history', [
            'login' => substr_replace($login, '****', 0, strlen($login)-2),
        ]);
    }

    public function get($login)
    {
        $login = decrypt($login);

        $i = 0; $result = []; $y=[];

        $info = $this->profit_history
            ->select('PROFTI_SUM', 'PROFIT_DATE')
            ->where('LOGIN', $login)
            ->orderBy('PROFIT_DATE', 'asc')
            ->get()
            ->toArray();

        $sum = $this->profit_history
            ->select('PROFTI_SUM')
            ->where('LOGIN', $login)
            ->orderBy('PROFTI_SUM', 'asc')
            ->get()
            ->toArray();

        foreach ($sum as $item) {
            $y[] = number_format($item['PROFTI_SUM'], 0);
        }

//        $info = array_reverse($info);

        foreach ($info as $value) {
            $result[$i]['name'] = $i;
            $result[$i]['value'][] = Carbon::parse($value['PROFIT_DATE'])->format('Y-m-d');
            $result[$i]['value'][] = number_format($value['PROFTI_SUM'], 0);
            $i++;
        }

        return response()->json(['y' => $y, 'info' => $result]);
    }

}