<?php

declare(strict_types=1);

namespace App\Http\Exceptions;

class MethodNotAllowedException extends \Exception
{
    public function __construct(string $message = 'Method Not Allowed')
    {
        parent::__construct($message, 405);
    }
}
