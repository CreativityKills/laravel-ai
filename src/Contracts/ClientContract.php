<?php

declare(strict_types=1);

namespace CreativityKills\LaravelAI\Contracts;

use CreativityKills\LaravelAI\Contracts\Resources\ChatContract;

interface ClientContract
{
    /**
     * Given a chat conversation, the model will return a chat completion response.
     */
    public function chat(): ChatContract;
}
