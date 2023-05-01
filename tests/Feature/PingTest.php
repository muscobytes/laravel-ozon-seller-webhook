<?php

namespace Muscobytes\OzonSeller\Tests\Feature;

use Illuminate\Support\Facades\Event;
use Muscobytes\OzonSeller\Events\PingEvent;
use Muscobytes\OzonSeller\Tests\TestCase;


class PingTest extends TestCase
{
    /** @test */
    function test_post_ping_message()
    {
        $this->withoutExceptionHandling();
        Event::fake();
        $payload = [
            'message_type' => 'TYPE_PING',
            'time' => '2019-08-24T14:15:22Z'
        ];
        $client_id = '314159265359';
        $response = $this->postJson(route('ozonseller.webhook', ['client_id' => $client_id]), $payload);
        $response->assertStatus(200);
        Event::assertDispatched(PingEvent::class);
    }
}
