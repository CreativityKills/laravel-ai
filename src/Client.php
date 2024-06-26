<?php

declare(strict_types=1);

namespace CreativityKills\LaravelAI;

use CreativityKills\LaravelAI\Resources\Chat;
use CreativityKills\LaravelAI\Contracts\ClientContract;
use CreativityKills\LaravelAI\Contracts\Resources\ChatContract;

class Client implements ClientContract
{
    public function __construct(
        protected ClientContract $client
    ) {
    }

    public function chat(): ChatContract
    {
        return new Chat($this->client);
    }
}
