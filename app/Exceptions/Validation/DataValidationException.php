<?php

namespace App\Exceptions\Validation;

use Exception;
use Illuminate\Http\Response;
use Throwable;

class DataValidationException extends Exception
{
    private array $errors;

    public function __construct(array $errors, string $message = "", int $code = 0, Throwable|null $previous = null)
    {
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }

    /**
     * Render the exception as an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        if ($request->wantsJson())
            return response()->json([
                'success' => false,
                'errors'  => $this->errors
            ], Response::HTTP_BAD_REQUEST);
    }
}
