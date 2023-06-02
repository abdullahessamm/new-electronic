<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function apiSuccessResponse(array $data = [], int $status = 200, array $headers = [], int $options = 0)
    {
        $msg = ['success' => true];
        foreach ($data as $key => $val)
            $msg[$key] = $val;

        return response()->json($msg, $status, $headers, $options);
    }
}
