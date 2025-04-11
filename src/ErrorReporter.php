<?php

namespace VersionWatch\ErrorReporter;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ErrorReporter
{
    protected static Client $client;

    public static function report(\Throwable $e): void
    {
        try {
            self::$client = new Client([
                'base_uri' => config('error-reporter.endpoint'),
                'timeout' => 5,
            ]);

            $payload = [
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'environment' => [
                    'php_version' => PHP_VERSION,
                    'laravel_version' => app()->version(),
                    'environment' => config('app.env'),
                ],
                'context' => [
                    'url' => request()->fullUrl(),
                    'user' => optional(auth()->user())->id,
                ]
            ];

            self::$client->post('/api/errors/report', [
                'headers' => [
                    'X-Project-ID' => config('error-reporter.project_id'),
                    'X-Project-Key' => config('error-reporter.api_key'),
                ],
                'json' => $payload
            ]);
        } catch (\Exception $e) {
            // Silent fail
        }
    }
}