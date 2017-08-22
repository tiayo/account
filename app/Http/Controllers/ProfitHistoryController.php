<?php

namespace App\Http\Controllers;

use App\ProfitHistory;

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
            'data' => json_encode($this->get($login)),
            'login' => $login,
        ]);
    }

    public function get($login)
    {
        $info = $this->profit_history
            ->select('PROFTI_SUM')
            ->where('LOGIN', $login)
            ->orderBy('PROFIT_DATE', 'desc')
            ->limit(1000)
            ->get()
            ->toArray();

        $info = array_reverse($info);

        $i = 0; $result = [];
        
        foreach ($info as $value) {
            $result[$i][] = $i;
            $result[$i][] = $value['PROFTI_SUM'];
            $i++;
        }

        return $result;
    }

}