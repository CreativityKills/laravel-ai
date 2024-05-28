<?php

declare(strict_types=1);

namespace CreativityKills\LaravelAI\Data;

use Webmozart\Assert\Assert;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
final class ResponseFormat implements Arrayable
{
    /**
     * @param  'json'  $type
     */
    public function __construct(
        public readonly string $type = 'json'
    ) {
        Assert::eq($type, 'json', 'Only "json" is supported');
    }

    /**
     * @return array{type: 'json'|'json_object'}
     */
    public function toArray(): array
    {
        return [
            'type' => match (Config::string('laravel-ai.provider')) {
                'openai' => 'json_object',
                default => $this->type,
            },
        ];
    }
}
