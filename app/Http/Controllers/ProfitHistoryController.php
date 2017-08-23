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
        return view('profit_history', [
            'login' => $login,
        ]);
    }

    public function get($login)
    {
        $info = $this->profit_history
            ->select('PROFTI_SUM', 'PROFIT_DATE')
            ->where('LOGIN', $login)
            ->orderBy('PROFIT_DATE', 'desc')
            ->get()
            ->toArray();

        $info = array_reverse($info);

        $i = 0; $result = [];
        
        foreach ($info as $value) {
            $result[$i]['name'] = $i;
            $result[$i]['value'][] = Carbon::parse($value['PROFIT_DATE'])->format('Ymd H:i:s');
            $result[$i]['value'][] = number_format($value['PROFTI_SUM'], 0);
            $i++;
        }

        return response()->json($result);
    }

}