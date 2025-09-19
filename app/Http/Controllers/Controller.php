<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function apiSuccessResponse(array $data = [], int $status = 200, array $headers = [], int $options = 0)
    {
        $msg = ['success' => true];
        foreach ($data as $key => $val)
            $msg[$key] = $val;

        return response()->json($msg, $status, $headers, $options);
    }
}
