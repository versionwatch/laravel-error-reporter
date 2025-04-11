<?php

namespace VersionWatch\ErrorReporter;

use Illuminate\Support\ServiceProvider;
use VersionWatch\ErrorReporter\Exceptions\ErrorReportingHandler as ExceptionsErrorReportingHandler;

class ErrorReporterServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/error-reporter.php', 'error-reporter');
        
        $this->app->singleton(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            ExceptionsErrorReportingHandler::class
        );
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/error-reporter.php' => config_path('error-reporter.php'),
            ], 'error-reporter-config');
        }
    }
}