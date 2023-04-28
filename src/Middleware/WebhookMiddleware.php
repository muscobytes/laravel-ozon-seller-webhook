<?php

namespace Muscobytes\OzonSeller\Middleware;

use Closure;
use Illuminate\Http\Request;
use Muscobytes\OzonSeller\EventType;
use Muscobytes\OzonSeller\Exceptions\EventTypeException;
use Muscobytes\OzonSeller\Exceptions\WebhookException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class WebhookMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     * @throws WebhookException
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (
            App::environment('production')
            && !$this->ipIsAllowed($request->ip())
        ) {
            throw new WebhookException("IP address ({$request->ip()}) is not allowed", 400);
        }

        try {
            $request->merge([
                'event_type' => EventType::fromRequest($request)
            ]);
        } catch (EventTypeException $e) {
            throw new WebhookException('Request type error', 400, $e);
        }
        return $next($request);
    }


    private function ipIsAllowed(string $ip): bool
    {
        $whitelist = config('ozonseller.webhook.whitelist');
        foreach ($whitelist as $range) {
            if ($this->ipInNetwork($ip, $range)) {
                return true;
            }
        }
        return false;
    }


    /**
     * Check if a given ip is in a network
     * https://gist.github.com/tott/7684443
     *
     * @param  string $ip    IP to check in IPV4 format e.g. 127.0.0.1
     * @param  string $range IP/CIDR netmask eg. 127.0.0.0/24, also 127.0.0.1 is accepted and /32 assumed
     * @return boolean true if the ip is in this range / false if not.
     */
    private function ipInNetwork(string $ip, string $range): bool
    {
        if (!str_contains($range, '/')) {
            $range .= '/32';
        }
        list($range, $netmask) = explode('/', $range, 2);
        $range_decimal = ip2long($range);
        $ip_decimal = ip2long($ip);
        $wildcard_decimal = pow(2, (32 - $netmask)) - 1;
        $netmask_decimal = ~ $wildcard_decimal;
        return (($ip_decimal & $netmask_decimal) == ($range_decimal & $netmask_decimal));
    }
}
