<?php

declare(strict_types=1);

namespace App\Http\Exceptions;

class NotFoundException extends \Exception
{
    public function __construct(string $message = 'Not Found')
    {
        parent::__construct($message, 404);
    }
}
