<?php

return [
    'enabled' => env('VERSIONWATCH_ERROR_REPORTING_ENABLED', true),
    'endpoint' => env('VERSIONWATCH_ERROR_REPORTING_ENDPOINT', 'https://errors.example.com'),
    'project_id' => env('VERSIONWATCH_ERROR_REPORTING_PROJECT_ID'),
    'api_key' => env('VERSIONWATCH_ERROR_REPORTING_API_KEY'),
    'ignored_exceptions' => [
        \Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class,
    ],

    'queue_enabled' => env('VERSIONWATCH_QUEUE_ENABLED', false),
    'queue_name' => env('VERSIONWATCH_QUEUE_NAME', 'versionwatch-errors'),
];