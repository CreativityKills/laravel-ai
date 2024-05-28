<?php

declare(strict_types=1);

namespace CreativityKills\LaravelAI\Enums;

enum Role: string
{
    case USER = 'user';
    case ASSISTANT = 'assistant';
    case SYSTEM = 'system';
}
