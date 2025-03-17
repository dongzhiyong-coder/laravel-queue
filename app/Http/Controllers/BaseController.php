<?php

namespace App\Http\Controllers;


class BaseController extends Controller
{
    //处理Null值
    private function parseNull(&$data)
    {
        if (is_array($data)) {
            foreach ($data as &$v) {
                $this->parseNull($v);
            }
        } else {
            if (null === $data) {
                $data = "";
            }
        }
    }

    public function success($data=[], $msg = "OK")
    {
        $this->parseNull($data);
        $result = [
            "code" => '0000',
            "msg" => $msg,
            "data" => $data,
        ];

        return response()->json($result, 200);
    }

    public function error($msg = "fail",$code='1001')
    {
        $result = [
            "code" => $code,
            "msg" => $msg,
            "data" => '',
        ];

        return response()->json($result, 200);
    }
}
