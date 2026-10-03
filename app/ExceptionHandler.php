<?php

declare(strict_types=1);

namespace App;

use App\View\RendererInterface;
use Throwable;

class ExceptionHandler
{
    public function __construct(
        private ?RendererInterface $view = null,
        private bool $debug = false
    ) {}

    public function register(): void
    {
        error_reporting(E_ALL);
        ini_set('display_errors', $this->debug ? '1' : '0');

        set_exception_handler([$this, 'handleException']);
        set_error_handler([$this, 'handleError']);
        // register_shutdown_function([$this, 'handleShutdown']);
    }

    public function handleException(Throwable $e): void
    {
        $status = $e->getCode();

        http_response_code($status);

        $this->view->render('error', [
            'status' => $status,
            'message' => $e->getMessage(),
            'debug' => $this->debug,
            'trace' => $this->debug ? $e->getTraceAsString() : null,
            'file' => $this->debug ? $e->getFile() : null,
            'line' => $this->debug ? $e->getLine() : null,
        ]);
    }

    public function handleError(
        int $severity,
        string $message,
        string $file = '',
        int $line = 0
    ): bool {
        // ignore errors if they are suppressed by the @
        if (!(error_reporting() & $severity)) {
            return false;
        }

        // and turn the error into a full exception
        throw new \ErrorException($message, 0, $severity, $file, $line);
    }

    public function handleShutdown(): void
    {
        // $error = error_get_last();
        // ...
    }
}
