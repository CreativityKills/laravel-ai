<?php

declare(strict_types=1);

namespace CreativityKills\LaravelAI\Exceptions;

use Exception;

class UnsupportedProvider extends Exception
{
    public static function create(string $provider): self
    {
        return new self("Unsupported provider: $provider");
    }
}
