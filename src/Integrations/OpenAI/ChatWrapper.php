<?php

declare(strict_types=1);

namespace CreativityKills\LaravelAI\Integrations\OpenAI;

use OpenAI\Client;
use CreativityKills\LaravelAI\Data\Chat\CreateOptions;
use CreativityKills\LaravelAI\Data\Chat\CreateResponse;
use CreativityKills\LaravelAI\Contracts\Resources\ChatContract;

class ChatWrapper implements ChatContract
{
    public function __construct(
        protected Client $client
    ) {
    }

    public function create(CreateOptions $options): CreateResponse
    {
        return CreateResponse::from(
            $this->client->chat()->create($options->toArray())->toArray()
        );
    }
}
