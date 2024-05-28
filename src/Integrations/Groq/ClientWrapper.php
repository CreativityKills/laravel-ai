<?php

declare(strict_types=1);

namespace CreativityKills\LaravelAI\Integrations\Groq;

use LucianoTonet\GroqPHP\Groq;
use CreativityKills\LaravelAI\Contracts\ClientContract;
use CreativityKills\LaravelAI\Contracts\Resources\ChatContract;

class ClientWrapper implements ClientContract
{
    public function __construct(
        protected Groq $client
    ) {
    }

    public function chat(): ChatContract
    {
        return new ChatWrapper($this->client);
    }
}
