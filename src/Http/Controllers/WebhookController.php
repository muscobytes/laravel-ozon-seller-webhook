<?php

namespace Muscobytes\OzonSeller\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function webhook(Request $request): JsonResponse
    {
        $et = $request->get('event_type');
        $response = match ($et) {
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
