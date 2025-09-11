<?php

// Helper function to get environment variable with default
if (!function_exists('env')) {
    function env($key, $default = null) {
        $value = getenv($key);
        if ($value === false) {
            return $default;
        }
        
        // Convert string booleans to actual booleans
        if (strtolower($value) === 'true') return true;
        if (strtolower($value) === 'false') return false;
        
        return $value;
    }
}

return [
    /**
     * The API endpoint to fetch pricing data from
     * Default: Vizra AI pricing API
     */
    'api_endpoint' => env('AI_TOKENS_API_ENDPOINT', 'https://vizra.ai/api/v1/pricing/ai-models'),
    
    /**
     * Cache duration in seconds
     * Default: 1 hour
     */
    'cache_duration' => (int) env('AI_TOKENS_CACHE_DURATION', 3600),
    
    /**
     * Whether to use remote pricing data
     * Set to false to only use local pricing data
     */
    'use_remote_pricing' => env('AI_TOKENS_USE_REMOTE', true),
    
    /**
     * Timeout for API requests in seconds
     */
    'timeout' => (int) env('AI_TOKENS_API_TIMEOUT', 5),
    
    /**
     * Cache directory for file-based caching
     * Used when not in a Laravel environment
     */
    'cache_directory' => env('AI_TOKENS_CACHE_DIR', sys_get_temp_dir() . '/ai-tokens-cache'),
];