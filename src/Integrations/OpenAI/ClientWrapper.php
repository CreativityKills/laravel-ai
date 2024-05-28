<?php

declare(strict_types=1);

namespace CreativityKills\LaravelAI\Integrations\OpenAI;

use OpenAI\Client;
use CreativityKills\LaravelAI\Contracts\ClientContract;
use CreativityKills\LaravelAI\Contracts\Resources\ChatContract;

class ClientWrapper implements ClientContract
{
    public function __construct(
        protected Client $client
    ) {
    }

    public function chat(): ChatContract
    {
        return new ChatWrapper($this->client);
    }
}
