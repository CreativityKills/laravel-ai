<?php

declare(strict_types=1);

namespace CreativityKills\LaravelAI;

use Illuminate\Support\Facades\Facade;
use CreativityKills\LaravelAI\Contracts\Resources\ChatContract;

/**
 * @method static ChatContract chat()
 */
class AI extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-ai';
    }
}
