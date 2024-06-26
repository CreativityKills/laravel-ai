<?php

declare(strict_types=1);

namespace CreativityKills\LaravelAI\Resources;

use CreativityKills\LaravelAI\Data\Chat\CreateOptions;
use CreativityKills\LaravelAI\Contracts\ClientContract;
use CreativityKills\LaravelAI\Data\Chat\CreateResponse;
use CreativityKills\LaravelAI\Contracts\Resources\ChatContract;

class Chat implements ChatContract
{
    public function __construct(
        protected ClientContract $client
    ) {
    }

    public function create(CreateOptions $options): CreateResponse
    {
        return CreateResponse::from(
            $this->client->chat()->create($options)->toArray()
        );
    }
}
