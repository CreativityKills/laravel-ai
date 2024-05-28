<?php

declare(strict_types=1);

namespace CreativityKills\LaravelAI\Exceptions;

use Exception;
use CreativityKills\LaravelAI\Enums\Model;

class UnsupportedModel extends Exception
{
    public static function model(Model $model, string $provider): self
    {
        return new self("Model {$model->value} is not supported for provider {$provider}");
    }
}
