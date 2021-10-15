<?php

namespace Tests;

use Exception;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Throwable;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp (): void
    {
        parent::setUp();
        $this->disableExceptionHandling();
    }

    protected function disableExceptionHandling ()
    {
        $this->oldExceptionHandler = app()->make(ExceptionHandler::class);
        app()->instance(ExceptionHandler::class, new PassThroughHandler);
    }

    protected function withExceptionHandling ()
    {
        app()->instance(ExceptionHandler::class, $this->oldExceptionHandler);
        return $this;
    }
}

class PassThroughHandler extends Handler
{
    public function __construct () {}

    public function report (Throwable $e) {}

    public function render ($request, Throwable $e)
    {
        throw $e;
    }
}