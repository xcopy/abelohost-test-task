<?php

declare(strict_types=1);

namespace App;

use App\View\RendererInterface;
use ErrorException;
use Throwable;

/**
 * Registers and handles application-level PHP errors and exceptions.
 */
class ExceptionHandler
{
    /**
     * Creates an exception handler.
     *
     * @param RendererInterface|null $view  Renderer used to display exceptions.
     * @param bool                   $debug Whether detailed exception data is shown.
     */
    public function __construct(
        private ?RendererInterface $view = null,
        private bool $debug = false
    ) {}

    /**
     * Registers this instance as the PHP error and exception handler.
     *
     * @return void
     */
    public function register(): void
    {
        error_reporting(E_ALL);

        ini_set('display_errors', $this->debug ? '1' : '0');

        set_exception_handler([$this, 'handleException']);
        set_error_handler([$this, 'handleError']);
        // register_shutdown_function([$this, 'handleShutdown']);
    }

    /**
     * Renders an uncaught exception using the configured view.
     *
     * @param Throwable $e The uncaught exception or error.
     *
     * @return void
     */
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

    /**
     * Converts an unsuppressed PHP error into an ErrorException.
     * Suppressed errors are left to PHP's default handling.
     *
     * @param int    $severity The error level.
     * @param string $message  The error message.
     * @param string $file     The file where the error occurred.
     * @param int    $line     The line where the error occurred.
     *
     * @return bool False when the error is suppressed.
     */
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
        throw new ErrorException($message, 0, $severity, $file, $line);
    }

    /**
     * Handles PHP shutdown processing.
     *
     * This method currently performs no shutdown handling.
     *
     * @return void
     */
    public function handleShutdown(): void
    {
        // $error = error_get_last();
        // ...
    }
}
