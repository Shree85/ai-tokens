<?php

namespace VizraAi\AiTokens\Config;

use VizraAi\AiTokens\PricingClient;

class Pricing
{
    public const LAST_UPDATED = '2025-09-09';

    public const PRICING_DATA = [
        // OpenAI Models
        'gpt-3.5-turbo' => [
            'input_price_per_million' => 1.50,
            'output_price_per_million' => 2.00,
            'chars_per_token' => 4.0,
        ],
        'gpt-4' => [
            'input_price_per_million' => 30.00,
            'output_price_per_million' => 60.00,
            'chars_per_token' => 4.0,
        ],
        'gpt-4-turbo' => [
            'input_price_per_million' => 10.00,
            'output_price_per_million' => 30.00,
            'chars_per_token' => 4.0,
        ],
        'gpt-4o' => [
            'input_price_per_million' => 2.50,
            'output_price_per_million' => 10.00,
            'chars_per_token' => 4.0,
        ],
        'gpt-4o-mini' => [
            'input_price_per_million' => 0.15,
            'output_price_per_million' => 0.60,
            'chars_per_token' => 4.0,
        ],
        'gpt-4.1' => [
            'input_price_per_million' => 2.00,
            'output_price_per_million' => 8.00,
            'chars_per_token' => 4.0,
        ],
        'gpt-4.1-mini' => [
            'input_price_per_million' => 0.40,
            'output_price_per_million' => 1.60,
            'chars_per_token' => 4.0,
        ],
        'gpt-4.1-nano' => [
            'input_price_per_million' => 0.10,
            'output_price_per_million' => 0.40,
            'chars_per_token' => 4.0,
        ],
        'gpt-4.5-preview' => [
            'input_price_per_million' => 75.00,
            'output_price_per_million' => 150.00,
            'chars_per_token' => 4.0,
        ],
        'chatgpt-4.1' => [
            'input_price_per_million' => 2.00,
            'output_price_per_million' => 8.00,
            'chars_per_token' => 4.0,
        ],
        'chatgpt-4.1-mini' => [
            'input_price_per_million' => 0.40,
            'output_price_per_million' => 1.60,
            'chars_per_token' => 4.0,
        ],
        'chatgpt-4.1-nano' => [
            'input_price_per_million' => 0.10,
            'output_price_per_million' => 0.40,
            'chars_per_token' => 4.0,
        ],
        'chatgpt-4o' => [
            'input_price_per_million' => 2.00,
            'output_price_per_million' => 8.00,
            'chars_per_token' => 4.0,
        ],
        'chatgpt-4o-mini' => [
            'input_price_per_million' => 0.60,
            'output_price_per_million' => 2.40,
            'chars_per_token' => 4.0,
        ],
        'o1-mini' => [
            'input_price_per_million' => 1.10,
            'output_price_per_million' => 4.40,
            'chars_per_token' => 4.0,
        ],
        'o1-preview' => [
            'input_price_per_million' => 15.00,
            'output_price_per_million' => 60.00,
            'chars_per_token' => 4.0,
        ],
        'o1-pro' => [
            'input_price_per_million' => 150.00,
            'output_price_per_million' => 600.00,
            'chars_per_token' => 4.0,
        ],
        'chatgpt-o1' => [
            'input_price_per_million' => 15.00,
            'output_price_per_million' => 60.00,
            'chars_per_token' => 4.0,
        ],
        'chatgpt-o3' => [
            'input_price_per_million' => 10.00,
            'output_price_per_million' => 40.00,
            'chars_per_token' => 4.0,
        ],
        'chatgpt-o3-mini' => [
            'input_price_per_million' => 1.10,
            'output_price_per_million' => 4.40,
            'chars_per_token' => 4.0,
        ],
        'chatgpt-o4-mini' => [
            'input_price_per_million' => 1.10,
            'output_price_per_million' => 4.40,
            'chars_per_token' => 4.0,
        ],

        // Anthropic Claude Models
        'claude-3-haiku' => [
            'input_price_per_million' => 0.25,
            'output_price_per_million' => 1.25,
            'chars_per_token' => 3.5,
        ],
        'claude-3-sonnet' => [
            'input_price_per_million' => 3.00,
            'output_price_per_million' => 15.00,
            'chars_per_token' => 3.5,
        ],
        'claude-3-opus' => [
            'input_price_per_million' => 15.00,
            'output_price_per_million' => 75.00,
            'chars_per_token' => 3.5,
        ],
        'claude-3.5-sonnet' => [
            'input_price_per_million' => 3.00,
            'output_price_per_million' => 15.00,
            'chars_per_token' => 3.5,
        ],
        'claude-3.5-haiku' => [
            'input_price_per_million' => 0.80,
            'output_price_per_million' => 4.00,
            'chars_per_token' => 3.5,
        ],
        'claude-3.7-sonnet' => [
            'input_price_per_million' => 3.00,
            'output_price_per_million' => 15.00,
            'chars_per_token' => 3.5,
        ],
        'claude-4-sonnet' => [
            'input_price_per_million' => 3.00,
            'output_price_per_million' => 15.00,
            'chars_per_token' => 3.5,
        ],
        'claude-4-opus' => [
            'input_price_per_million' => 15.00,
            'output_price_per_million' => 75.00,
            'chars_per_token' => 3.5,
        ],

        // Google Gemini Models
        'gemini-pro' => [
            'input_price_per_million' => 0.50,
            'output_price_per_million' => 1.50,
            'chars_per_token' => 4.0,
        ],
        'gemini-1.5-pro' => [
            'input_price_per_million' => 1.25,
            'output_price_per_million' => 5.00,
            'chars_per_token' => 4.0,
        ],
        'gemini-1.5-flash' => [
            'input_price_per_million' => 0.075,
            'output_price_per_million' => 0.30,
            'chars_per_token' => 4.0,
        ],
        'gemini-2.0-flash' => [
            'input_price_per_million' => 0.10,
            'output_price_per_million' => 0.40,
            'chars_per_token' => 4.0,
        ],
        'gemini-2.0-flash-lite' => [
            'input_price_per_million' => 0.075,
            'output_price_per_million' => 0.30,
            'chars_per_token' => 4.0,
        ],
        'gemini-2.5-flash' => [
            'input_price_per_million' => 0.30,
            'output_price_per_million' => 2.50,
            'chars_per_token' => 4.0,
        ],
        'gemini-2.5-flash-lite' => [
            'input_price_per_million' => 0.10,
            'output_price_per_million' => 0.40,
            'chars_per_token' => 4.0,
        ],
        'gemini-2.5-pro' => [
            'input_price_per_million' => 1.25,
            'output_price_per_million' => 10.00,
            'chars_per_token' => 4.0,
        ],

        // DeepSeek Models
        'deepseek-v3' => [
            'input_price_per_million' => 0.27,
            'output_price_per_million' => 1.10,
            'chars_per_token' => 4.0,
        ],
        'deepseek-r1' => [
            'input_price_per_million' => 0.55,
            'output_price_per_million' => 2.19,
            'chars_per_token' => 4.0,
        ],
        'deepseek-coder' => [
            'input_price_per_million' => 0.14,
            'output_price_per_million' => 0.28,
            'chars_per_token' => 4.0,
        ],

        // Mistral Models
        'mistral-tiny' => [
            'input_price_per_million' => 0.25,
            'output_price_per_million' => 0.25,
            'chars_per_token' => 4.0,
        ],
        'mistral-small' => [
            'input_price_per_million' => 0.10,
            'output_price_per_million' => 0.30,
            'chars_per_token' => 4.0,
        ],
        'mistral-medium' => [
            'input_price_per_million' => 0.40,
            'output_price_per_million' => 2.00,
            'chars_per_token' => 4.0,
        ],
        'mistral-large' => [
            'input_price_per_million' => 2.00,
            'output_price_per_million' => 6.00,
            'chars_per_token' => 4.0,
        ],

        // xAI Grok Models
        'grok-3' => [
            'input_price_per_million' => 3.00,
            'output_price_per_million' => 15.00,
            'chars_per_token' => 4.0,
        ],
        'grok-3-mini' => [
            'input_price_per_million' => 0.60,
            'output_price_per_million' => 3.00,
            'chars_per_token' => 4.0,
        ],
        'grok-beta' => [
            'input_price_per_million' => 5.00,
            'output_price_per_million' => 15.00,
            'chars_per_token' => 4.0,
        ],

        // Meta Llama Models
        'llama-3.1-8b' => [
            'input_price_per_million' => 0.30,
            'output_price_per_million' => 0.60,
            'chars_per_token' => 4.0,
        ],
        'llama-3.1-70b' => [
            'input_price_per_million' => 2.65,
            'output_price_per_million' => 3.50,
            'chars_per_token' => 4.0,
        ],
        'llama-3.1-405b' => [
            'input_price_per_million' => 5.00,
            'output_price_per_million' => 15.00,
            'chars_per_token' => 4.0,
        ],

        // Cohere Models
        'command' => [
            'input_price_per_million' => 1.00,
            'output_price_per_million' => 2.00,
            'chars_per_token' => 4.0,
        ],
        'command-light' => [
            'input_price_per_million' => 0.30,
            'output_price_per_million' => 0.60,
            'chars_per_token' => 4.0,
        ],
        'command-r' => [
            'input_price_per_million' => 0.15,
            'output_price_per_million' => 0.60,
            'chars_per_token' => 4.0,
        ],
        'command-r-plus' => [
            'input_price_per_million' => 2.50,
            'output_price_per_million' => 10.00,
            'chars_per_token' => 4.0,
        ],
    ];

    private static ?array $remotePricing = null;
    private static ?PricingClient $client = null;

    /**
     * Get pricing for a specific model
     */
    public static function getModelPricing(string $model): ?array
    {
        // Try to fetch remote pricing first
        if (self::$remotePricing === null && self::shouldUseRemotePricing()) {
            self::fetchRemotePricing();
        }

        // Check remote pricing first
        if (self::$remotePricing !== null && isset(self::$remotePricing[$model])) {
            return self::$remotePricing[$model];
        }

        // Fall back to local pricing
        return self::PRICING_DATA[$model] ?? null;
    }

    /**
     * Get all supported models
     */
    public static function getSupportedModels(): array
    {
        // Try to fetch remote pricing first
        if (self::$remotePricing === null && self::shouldUseRemotePricing()) {
            self::fetchRemotePricing();
        }

        // Combine remote and local models
        $models = array_keys(self::PRICING_DATA);
        
        if (self::$remotePricing !== null) {
            $remoteModels = array_keys(self::$remotePricing);
            $models = array_unique(array_merge($models, $remoteModels));
        }

        sort($models);
        return $models;
    }

    /**
     * Get the last updated date
     */
    public static function getLastUpdated(): string
    {
        return self::LAST_UPDATED;
    }

    /**
     * Check if remote pricing should be used
     */
    private static function shouldUseRemotePricing(): bool
    {
        // Check for environment variable to disable remote pricing
        if (getenv('AI_TOKENS_USE_REMOTE_PRICING') === 'false') {
            return false;
        }

        // Check if we're in a Laravel environment
        if (function_exists('config')) {
            return config('ai-tokens.use_remote_pricing', true);
        }

        return true;
    }

    /**
     * Fetch remote pricing data
     */
    private static function fetchRemotePricing(): void
    {
        if (self::$client === null) {
            self::$client = new PricingClient();
        }

        self::$remotePricing = self::$client->fetchRemotePricing();
    }

    /**
     * Clear cached remote pricing
     */
    public static function clearCache(): void
    {
        self::$remotePricing = null;
        
        if (self::$client !== null) {
            self::$client->clearCache();
        }
    }
}