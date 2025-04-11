// config/error-reporter.php
<?php

return [
    'enabled' => env('VERSIONWATCH_ERROR_REPORTING_ENABLED', true),
    'endpoint' => env('VERSIONWATCH_ERROR_REPORTING_ENDPOINT', 'https://errors.example.com'),
    'project_id' => env('VERSIONWATCH_ERROR_REPORTING_PROJECT_ID'),
    'api_key' => env('VERSIONWATCH_ERROR_REPORTING_API_KEY'),
    'ignored_exceptions' => [
        \Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class,
    ],
];