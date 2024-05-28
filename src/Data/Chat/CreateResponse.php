<?php

declare(strict_types=1);

namespace CreativityKills\LaravelAI\Data\Chat;

use Webmozart\Assert\Assert;
use OpenAI\Responses\Concerns\ArrayAccessible;
use CreativityKills\LaravelAI\Contracts\ResponseContract;

/**
 * @implements ResponseContract<array{id: string, object: string, created: int, model: string, system_fingerprint?: string, choices: array<int, array{index: int, message: array{role: string, content: ?string}, finish_reason: ?string}>, usage: array{prompt_tokens: int, completion_tokens: int|null, total_tokens: int}}>
 */
final class CreateResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<array{id: string, object: string, created: int, model: string, system_fingerprint?: string, choices: array<int, array{index: int, message: array{role: string, content: ?string}, finish_reason: ?string}>, usage: array{prompt_tokens: int, completion_tokens: int|null, total_tokens: int}}>
     */
    use ArrayAccessible;

    /**
     * @param  array<CreateResponseChoice>  $choices
     */
    private function __construct(
        public readonly string $id,
        public readonly string $object,
        public readonly int $created,
        public readonly string $model,
        public readonly ?string $systemFingerprint,
        public readonly array $choices,
        public readonly CreateResponseUsage $usage,
    ) {
        Assert::allIsInstanceOf($choices, CreateResponseChoice::class);
    }

    /**
     * @param  array{id: string, object: string, created: int, model: string, system_fingerprint?: string, choices: array<int, array{index: int, message: array{role: string, content: ?string}, finish_reason: ?string}>, usage: array{prompt_tokens: int, completion_tokens: int|null, total_tokens: int}}  $data
     */
    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            object: $data['object'],
            created: $data['created'],
            model: $data['model'],
            systemFingerprint: $data['system_fingerprint'] ?? null,
            choices: array_map(
                static fn (array $choice) => CreateResponseChoice::from($choice),
                $data['choices'],
            ),
            usage: CreateResponseUsage::from($data['usage']),
        );
    }

    /**
     * @return array{id: string, object: string, created: int, model: string, system_fingerprint?: string, choices: array<int, array{index: int, message: array{role: string, content: ?string}, finish_reason: ?string}>, usage: array{prompt_tokens: int, completion_tokens: int|null, total_tokens: int}}
     */
    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'object' => $this->object,
            'created' => $this->created,
            'model' => $this->model,
            'system_fingerprint' => $this->systemFingerprint,
            'choices' => array_map(
                static fn (CreateResponseChoice $result) => $result->toArray(),
                $this->choices,
            ),
            'usage' => $this->usage->toArray(),
        ], fn (mixed $value) => $value !== null);
    }
}
