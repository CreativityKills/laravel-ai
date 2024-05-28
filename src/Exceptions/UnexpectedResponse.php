<?php

declare(strict_types=1);

namespace CreativityKills\LaravelAI\Exceptions;

use Exception;

class UnexpectedResponse extends Exception
{
    public static function create(string $message = 'Unexpected response from the API'): self
    {
        return new self($message);
    }
}
