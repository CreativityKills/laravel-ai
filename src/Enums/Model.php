<?php

declare(strict_types=1);

namespace CreativityKills\LaravelAI\Enums;

use Illuminate\Support\Arr;
use Webmozart\Assert\Assert;

enum Model: string
{
    // OpenAI Models
    case GPT4o = 'gpt-4o';
    case GPT4_TURBO = 'gpt-4-turbo';
    case GPT4 = 'gpt-4';
    case GPT3_5_TURBO_16k = 'gpt-3.5-turbo-16k';

    // Groq Models
    case LLAMA3_8B_8192 = 'llama3-8b-8192';
    case LLAMA3_70B_8192 = 'llama3-70b-8192';
    case GEMMA_7B_IT = 'gemma-7b-it';
    case MISTRAL_8X7B_32768 = 'mixtral-8x7b-32768';

    public function isSupportedForProvider(string $provider): bool
    {
        $supportedProviders = array_keys(Arr::wrap(config('ai.providers')));

        Assert::oneOf($provider, $supportedProviders);

        $modelsHashMap = [
            'openai' => [self::GPT4o, self::GPT4_TURBO, self::GPT4, self::GPT3_5_TURBO_16k],
            'groq' => [self::LLAMA3_8B_8192, self::LLAMA3_70B_8192, self::GEMMA_7B_IT, self::MISTRAL_8X7B_32768],
        ];

        return in_array($this, $modelsHashMap[$provider]);
    }

    public function isNotSupportedForProvider(string $provider): bool
    {
        return ! $this->isSupportedForProvider($provider);
    }
}
