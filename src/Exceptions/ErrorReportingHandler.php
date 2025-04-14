<?php

namespace VersionWatch\ErrorReporter\Exceptions;

use Illuminate\Foundation\Exceptions\Handler;
use Throwable;
use VersionWatch\ErrorReporter\ErrorReporter;

class ErrorReportingHandler extends Handler
{
    public function report(Throwable $e)
    {
        /*if ($this->shouldReport($e) && config('vw-error-reporter.queue_enabled')) {
            ErrorReporter::report($e);
        }*/
        parent::report($e);
    }
}