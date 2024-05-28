<?php

declare(strict_types=1);

use CreativityKills\LaravelAI\Enums\Model;

return [
    /*
    |--------------------------------------------------------------------------
    | Default Provider
    |--------------------------------------------------------------------------
    |
    | This option controls the default provider that will be used to generate
    | text using the AI service. You may change the default provider to
    | any of the providers listed below.
    |
    | Supported: "openai", "groq"
    |
    */

    'provider' => env('AI_LLM_PROVIDER', 'openai'),

    /*
    |--------------------------------------------------------------------------
    | System Message
    |--------------------------------------------------------------------------
    |
    | This option controls the system message that will be used to generate
    | text using the AI service. The system message is a message that is
    | sent to the AI service to provide context and instructions for
    | generating text.
    |
    */

    'system_message' => env('AI_LLM_SYSTEM_MESSAGE', 'You are a helpful assistant.'),

    /*
    |--------------------------------------------------------------------------
    | Model
    |--------------------------------------------------------------------------
    |
    | This option controls the model that will be used to generate text using
    | the AI service. The model is a specific type of AI model that is
    | trained on a large dataset to generate text.
    |
    */

    'model' => env('AI_LLM_MODEL', Model::GPT3_5_TURBO_16k->value),

    /*
    |--------------------------------------------------------------------------
    | Providers
    |--------------------------------------------------------------------------
    |
    | This array contains the available providers for generating text using
    | the AI service. Each provider is defined by a unique name and a
    | configuration array.
    |
    */

    'providers' => [
        'openai' => [
            /*
            |--------------------------------------------------------------------------
            | OpenAI API Key and Organization
            |--------------------------------------------------------------------------
            |
            | Here you may specify your OpenAI API Key and organization. This will be
            | used to authenticate with the OpenAI API - you can find your API key
            | and organization on your OpenAI dashboard, at https://openai.com.
            */

            'api_key' => env('OPENAI_API_KEY'),
            'organization' => env('OPENAI_ORGANIZATION'),

            /*
            |--------------------------------------------------------------------------
            | Request Timeout
            |--------------------------------------------------------------------------
            |
            | The timeout may be used to specify the maximum number of seconds to wait
            | for a response. By default, the client will time out after 30 seconds.
            */

            'request_timeout' => env('OPENAI_REQUEST_TIMEOUT', 30),
        ],

        'groq' => [
            'api_key' => env('GROQ_API_KEY'),
        ],
    ],
];
