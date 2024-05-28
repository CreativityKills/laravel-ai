<?php

declare(strict_types=1);

namespace CreativityKills\LaravelAI;

use OpenAI;
use Throwable;
use GuzzleHttp;
use Webmozart\Assert\Assert;
use LucianoTonet\GroqPHP\Groq;
use OpenAI\Client as OpenAIClient;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Support\DeferrableProvider;
use CreativityKills\LaravelAI\Contracts\ClientContract;
use CreativityKills\LaravelAI\Client as LaravelAIClient;
use CreativityKills\LaravelAI\Exceptions\ApiKeyIsMissing;
use CreativityKills\LaravelAI\Exceptions\UnsupportedProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use CreativityKills\LaravelAI\Integrations\Groq\ClientWrapper as GroqClientWrapper;
use CreativityKills\LaravelAI\Integrations\OpenAI\ClientWrapper as OpenAIClientWrapper;

final class ServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ClientContract::class, function () {
            $provider = Config::string('ai.provider');

            return new LaravelAIClient(
                match ($provider) {
                    'openai' => new OpenAIClientWrapper($this->getOpenAIClient()),
                    'groq' => new GroqClientWrapper($this->getGroqClient()),
                    default => throw UnsupportedProvider::create($provider),
                }
            );
        });

        $this->app->alias(ClientContract::class, 'laravel-ai');
        $this->app->alias(ClientContract::class, LaravelAIClient::class);
    }

    /**
     * Get the OpenAI client.
     */
    protected function getOpenAIClient(): OpenAIClient
    {
        $apiKey = Config::string('ai.providers.openai.api_key');
        $organization = Config::string('ai.providers.openai.organization');

        try {
            Assert::string($apiKey);
            Assert::nullOrString($organization);
        } catch (Throwable) {
            throw ApiKeyIsMissing::create('openai');
        }

        return OpenAI::factory()
            ->withApiKey($apiKey)
            ->withOrganization($organization)
            ->withHttpHeader('OpenAI-Beta', 'assistants=v1')
            ->withHttpClient(new GuzzleHttp\Client([
                'timeout' => Config::integer('ai.providers.openai.request_timeout', 30),
            ]))
            ->make();
    }

    public function getGroqClient(): Groq
    {
        $apiKey = Config::string('ai.providers.groq.api_key');

        throw_unless(filled($apiKey), ApiKeyIsMissing::create('groq'));

        return new Groq($apiKey);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/ai.php' => config_path('ai.php'),
            ]);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [LaravelAIClient::class, ClientContract::class, 'laravel-ai'];
    }
}
