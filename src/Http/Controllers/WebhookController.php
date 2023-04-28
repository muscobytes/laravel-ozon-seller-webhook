<?php

namespace Muscobytes\OzonSeller\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function webhook(Request $request): JsonResponse
    {
        $response = match ($request->get('event_type')) {
            'TYPE_PING' => [
                'version' => '',
                'name' => config('app.name'),
                'time' => Carbon::now()->toIso8601ZuluString()
            ],
            default => [
                'result' => 'true'
            ],
        };
        return response()->json($response);
    }
}
