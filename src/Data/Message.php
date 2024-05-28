<?php

declare(strict_types=1);

namespace CreativityKills\LaravelAI\Data;

use CreativityKills\LaravelAI\Enums\Role;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
final class Message implements Arrayable
{
    public function __construct(
        public readonly Role $role,
        public readonly string $content,
    ) {
    }

    /**
     * @return array{role: string, content: string}
     */
    public function toArray(): array
    {
        return [
            'role' => $this->role->value,
            'content' => $this->content,
        ];
    }
}
