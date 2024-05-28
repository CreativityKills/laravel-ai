<?php

declare(strict_types=1);

namespace CreativityKills\LaravelAI\Resources;

use CreativityKills\LaravelAI\Data\Chat\CreateOptions;
use CreativityKills\LaravelAI\Data\Chat\CreateResponse;
use OpenAI\Contracts\ClientContract as OpenAIClientContract;
use CreativityKills\LaravelAI\Contracts\Resources\ChatContract;

class Chat implements ChatContract
{
    public function __construct(
        protected OpenAIClientContract $client
    ) {
    }

    public function create(CreateOptions $options): CreateResponse
    {
        $parameters = $options->toArray();

        return CreateResponse::from(
            $this->client->chat()->create($parameters)->toArray()
        );
    }
}
