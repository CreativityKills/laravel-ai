<?php

declare(strict_types=1);

namespace CreativityKills\LaravelAI;

use OpenAI;
use Throwable;
use GuzzleHttp;
use Webmozart\Assert\Assert;
use OpenAI\Client as OpenAIClient;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Support\DeferrableProvider;
use CreativityKills\LaravelAI\Contracts\ClientContract;
use CreativityKills\LaravelAI\Exceptions\ApiKeyIsMissing;
use CreativityKills\LaravelAI\Exceptions\UnsupportedProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

final class ServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ClientContract::class, function () {
            $provider = Config::string('laravel-ai.provider');

            return new Client(
                match ($provider) {
                    'openai' => $this->getOpenAIClient(),
                    default => throw UnsupportedProvider::create($provider),
                }
            );
        });

        $this->app->alias(ClientContract::class, 'laravel-ai');
        $this->app->alias(ClientContract::class, Client::class);
    }

    /**
     * Get the OpenAI client.
     */
    protected function getOpenAIClient(): OpenAIClient
    {
        $apiKey = Config::string('laravel-ai.openai.api_key');
        $organization = Config::string('laravel-ai.openai.organization');

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
                'timeout' => Config::integer('laravel-ai.openai.request_timeout', 30),
            ]))
            ->make();
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
        return [Client::class, ClientContract::class, 'laravel-ai'];
    }
}
