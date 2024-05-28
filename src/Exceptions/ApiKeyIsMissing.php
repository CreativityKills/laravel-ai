<?php

declare(strict_types=1);

namespace CreativityKills\LaravelAI\Exceptions;

use Exception;

final class ApiKeyIsMissing extends Exception
{
    public static function create(string $provider): self
    {
        return new self("The API key for the $provider provider is missing.");
    }
}
