<?php

declare(strict_types=1);

namespace CreativityKills\LaravelAI\Data\Chat;

final class CreateResponseChoice
{
    private function __construct(
        public readonly int $index,
        public readonly CreateResponseMessage $message,
        public readonly ?string $finishReason,
    ) {
    }

    /**
     * @param  array{index: int, message: array{role: string, content: ?string}, finish_reason: ?string}  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['index'],
            CreateResponseMessage::from($attributes['message']),
            $attributes['finish_reason'] ?? null,
        );
    }

    /**
     * @return array{index: int, message: array{role: string, content: ?string}, finish_reason: ?string}
     */
    public function toArray(): array
    {
        return [
            'index' => $this->index,
            'message' => $this->message->toArray(),
            'finish_reason' => $this->finishReason,
        ];
    }
}
