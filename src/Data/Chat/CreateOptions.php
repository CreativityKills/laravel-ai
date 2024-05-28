<?php

declare(strict_types=1);

namespace CreativityKills\LaravelAI\Data\Chat;

use Illuminate\Support\Arr;
use Webmozart\Assert\Assert;
use Illuminate\Support\Facades\Config;
use CreativityKills\LaravelAI\Enums\Role;
use CreativityKills\LaravelAI\Enums\Model;
use CreativityKills\LaravelAI\Data\Message;
use CreativityKills\LaravelAI\Data\ResponseFormat;
use CreativityKills\LaravelAI\Exceptions\UnsupportedModel;

final class CreateOptions
{
    /**
     * @var array<Message>
     */
    public readonly array $messages;

    public readonly Model $model;

    /**
     * @param  array<Message>  $messages
     */
    public function __construct(
        array|Message $messages,
        ?Model $model = null,
        ?Message $systemMessage = null,
        public readonly float $frequencyPenalty = 0,
        public readonly ?int $maxTokens = null,
        public readonly ?int $n = null,
        public readonly float $presencePenalty = 0,
        public readonly ?ResponseFormat $responseFormat = null,
        public readonly bool $stream = false,
        public readonly float $temperature = 1,
        public readonly ?string $user = null,
    ) {
        $model ??= Model::from(Config::string('ai.model'));
        $systemMessage ??= new Message(role: Role::SYSTEM, content: Config::string('ai.system_message'));

        $this->model = $model;
        $this->messages = [$systemMessage, ...Arr::wrap($messages)];

        $this->validate();
    }

    /**
     * @return array{messages: array{role: string, content: string}[], model: string, frequency_penalty: float, max_tokens?: int, n?: int, presence_penalty: float, response_format?: array{type: string}, stream: bool, temperature: float, user?: string}
     */
    public function toArray(): array
    {
        return array_filter([
            'messages' => array_map(fn (Message $message) => $message->toArray(), $this->messages),
            'model' => $this->model->value,
            'frequency_penalty' => $this->frequencyPenalty,
            'max_tokens' => $this->maxTokens,
            'n' => $this->n,
            'presence_penalty' => $this->presencePenalty,
            'response_format' => $this->responseFormat?->toArray(),
            'stream' => $this->stream,
            'temperature' => $this->temperature,
            'user' => $this->user,
        ], fn (mixed $value) => $value !== null);
    }

    protected function validate(): void
    {
        $provider = Config::string('ai.provider');

        // Validation for the messages
        Assert::allIsInstanceOf($this->messages, Message::class);

        // Validation for the model
        throw_if($this->model->isNotSupportedForProvider($provider), UnsupportedModel::model($this->model, $provider));

        // Validation for the frequency penalty
        Assert::lessThanEq($this->frequencyPenalty, 2.0);
        Assert::greaterThanEq($this->frequencyPenalty, -2.0);

        // Validation for the max tokens
        Assert::nullOrPositiveInteger($this->maxTokens);

        // Validation for the n
        Assert::nullOrPositiveInteger($this->n);

        // validation for the presence penalty
        Assert::lessThanEq($this->presencePenalty, 2.0);
        Assert::greaterThanEq($this->presencePenalty, -2.0);

        // Validation for the temperature
        Assert::lessThanEq($this->temperature, 2.0);
        Assert::greaterThanEq($this->temperature, 0);
    }
}
