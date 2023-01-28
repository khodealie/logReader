<?php

namespace Tests\Feature;

use App\Models\Log;
use Tests\TestCase;

class GetLogCountTest extends TestCase
{
    private function headers(): array
    {
        return $this->transformHeadersToServerVars(['Accept' => 'application/json', 'Content-Type' => 'application/json']);
    }

    public function test_error_422(): void
    {
        $response = $this->call('GET', '/logs/count', ['serviceNames' => 'foo'], server: $this->headers());
        $response->assertStatus(422);
    }

    public function test_body_format()
    {
        $response = $this->call('GET', '/logs/count', server: $this->headers());
        $responseJson = $response->decodeResponseJson();
        $this->assertArrayHasKey('count', $responseJson);
    }

    public function test_response_verification_true()
    {
        $response = $this->call('GET', '/logs/count', server: $this->headers());
        $responseJson = $response->decodeResponseJson();
        $this->assertEquals(Log::filterViaParams([])->count(), $responseJson['count']);
    }

    public function test_response_verification_false()
    {
        $response = $this->call('GET', '/logs/count', ['serviceNames' => ['order-service']], server: $this->headers());
        $responseJson = $response->decodeResponseJson();
        $this->assertNotEquals(Log::filterViaParams([])->count(), $responseJson['count']);
    }
}
