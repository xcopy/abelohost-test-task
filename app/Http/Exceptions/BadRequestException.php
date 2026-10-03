<?php

declare(strict_types=1);

namespace App\Http\Exceptions;

class BadRequestException extends \Exception
{
    public function __construct(string $message = 'Bad Request')
    {
        parent::__construct($message, 400);
    }
}
