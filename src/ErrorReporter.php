<?php

namespace VersionWatch\ErrorReporter;

use Illuminate\Support\Facades\Http;

class ErrorReporter
{
    protected static $client;

    public static function report(\Throwable $e): void
    {
        if (config('vw-error-reporter.enabled')) {
            dispatch(function () use ($e) {
                self::sendReport($e);
            })->onQueue('error-reports');
        } else {
            self::sendReport($e);
        }
    }

    private static function sendReport(\Throwable $e): void
    {
        try {
            self::$client = Http::withOptions([
                'timeout' => 5,
            ])
            ->baseUrl(config('vw-error-reporter.endpoint'))
            ->withHeaders([
                'X-Project-ID' => config('vw-error-reporter.project_id'),
                'X-Project-Key' => config('vw-error-reporter.api_key'),
            ])
            ->acceptJson();
                
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
                    'user' => optional(auth()->user())->id ?? null,
                    'ip' => request()->ip(),
                ],
            ];
           
            $res = self::$client->post(config('vw-error-reporter.endpoint'), $payload);
        } catch (\Exception $e) {
            // Silent fail
        }
    }
}