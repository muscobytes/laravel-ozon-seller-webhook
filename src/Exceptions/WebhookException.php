<?php

namespace Muscobytes\OzonSeller\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class WebhookException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'error' => [
                'code' => 'ERROR_UNKNOWN',
                'message' => $this->getMessage(),
                'details' => ''
            ]
        ], $this->getCode() ?: 400);
    }
}
