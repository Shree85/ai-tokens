<?php

namespace VizraAi\AiTokens\Laravel;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use VizraAi\AiTokens\TokenCounter;

class ServiceProvider extends LaravelServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(TokenCounter::class, function () {
            return new TokenCounter();
        });

        $this->app->alias(TokenCounter::class, 'ai-tokens');
    }

    public function boot(): void
    {
        // Nothing to boot for now
    }

    public function provides(): array
    {
        return [
            TokenCounter::class,
            'ai-tokens',
        ];
    }
}