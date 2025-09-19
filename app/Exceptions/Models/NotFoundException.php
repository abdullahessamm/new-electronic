<?php

namespace App\Exceptions\Models;

use Exception;

class NotFoundException extends Exception
{
    private string $model;
    private string $object;

    public function __construct(string $model, string $object)
    {
        $this->object = $object;
        $this->model = substr($model, strrpos($model, '\\') + 1);
    }

    public function render()
    {
        return response()->json([
            'success' => false,
            'message' => $this->model . '(' . $this->object . ')' . ' not found!'
        ], 404);   
    }
}
