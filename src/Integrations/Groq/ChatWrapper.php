<?php

declare(strict_types=1);

namespace CreativityKills\LaravelAI\Integrations\Groq;

use LucianoTonet\GroqPHP\Groq;
use Illuminate\Support\Facades\Context;
use CreativityKills\LaravelAI\Data\Chat\CreateOptions;
use CreativityKills\LaravelAI\Data\Chat\CreateResponse;
use CreativityKills\LaravelAI\Exceptions\UnexpectedResponse;
use CreativityKills\LaravelAI\Contracts\Resources\ChatContract;

class ChatWrapper implements ChatContract
{
    public function __construct(
        protected Groq $client
    ) {
    }

    public function create(CreateOptions $options): CreateResponse
    {
        $response = $this->client->chat()->completions()->create($options->toArray());

        if (! is_array($response)) {
            throw UnexpectedResponse::create();
        }

        Context::add('groq_response', $response);

        // @phpstan-ignore-next-line
        return CreateResponse::from($response);
    }
}
