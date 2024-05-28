<?php

declare(strict_types=1);

namespace CreativityKills\LaravelAI\Integrations\OpenAI;

use OpenAI\Client;
use Illuminate\Support\Facades\Context;
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
        Context::add('openai_options', $options);

        $response = $this->client->chat()->create($options->toArray())->toArray();

        Context::add('openai_response', $response);

        return CreateResponse::from($response);
    }
}
