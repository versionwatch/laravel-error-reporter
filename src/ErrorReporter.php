<?php

namespace VersionWatch\ErrorReporter;

use Illuminate\Support\Facades\Http;
use Throwable;

class ErrorReporter
{
    protected static $client;

    public static function report(Throwable $e): void
    {
        $exception = self::formatException($e);

        if (config('vw-error-reporter.queue_enabled')) {
            dispatch(function () use ($exception) {
                self::sendReport($exception);
            })->onQueue(config('vw-error-reporter.queue_name'));
        } else {
            self::sendReport($exception);
        }
    }

    private static function formatException(Throwable $e)
    {
        $payload = [
            'exception' => get_class($e),
            'message' => $e->getMessage(),
            'stack_trace' => $e->getTraceAsString(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'environment' => [
                'language' => "PHP " . PHP_VERSION,
                'framework' => "laravel",
                'version' => app()->version(),
                'environment' => config('app.env'),
            ],
            'context' => [
                'url' => request()->fullUrl(),
                'user' => optional(auth()->user())->id ?? null,
                'ip' => request()->ip(),
            ],
            'project_id' => config('vw-error-reporter.project_id'),
            'api_key' => config('vw-error-reporter.api_key'),
        ];

        return $payload;
    }

    private static function sendReport(array $payload): void
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
                
            self::$client->post(config('vw-error-reporter.endpoint'), $payload);
        } catch (\Exception $e) {
            // Silent fail
        }
    }
}