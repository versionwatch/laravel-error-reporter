<?php

namespace VersionWatch\ErrorReporter;

use App\Exceptions\Handler;
use Illuminate\Support\ServiceProvider;
use VersionWatch\ErrorReporter\Exceptions\ErrorReportingHandler as ExceptionsErrorReportingHandler;

class ErrorReporterServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/vw-error-reporter.php', 'vw-error-reporter');
        
        $this->app->singleton(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            Handler::class
        );
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/vw-error-reporter.php' => config_path('vw-error-reporter.php'),
            ], 'vw-error-reporter');
        }
    }
}