<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function wsSecret(Request $request)
    {
        //助战模式：判断来访是否本站
        $status = $request->session()->pull('wsSecret');

        //客户模式：判断用户token(保留方法)
        if (!$status) {
            return response()->json('验证失败！', 403);
        }

        //获取要加密串
        $str = $request->get('str');

        return response()->json([
            'msg_type' => 1000,
            'encode' => strrev(md5(strrev(base64_encode($str)))),
        ]);
    }
}
