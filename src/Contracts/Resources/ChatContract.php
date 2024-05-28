<?php

declare(strict_types=1);

namespace CreativityKills\LaravelAI\Contracts\Resources;

use CreativityKills\LaravelAI\Data\Chat\CreateOptions;
use CreativityKills\LaravelAI\Data\Chat\CreateResponse;

interface ChatContract
{
    /**
     * Creates a completion for the chat message
     */
    public function create(CreateOptions $options): CreateResponse;
}
