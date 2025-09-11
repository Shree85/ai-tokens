<?php

namespace VizraAi\AiTokens;

use VizraAi\AiTokens\Cache\FileCache;

class PricingClient
{
    private FileCache $cache;
    private array $config;
    
    public function __construct(?array $config = null)
    {
        $defaults = $this->getDefaultConfig();
        $this->config = $config ? array_merge($defaults, $config) : $defaults;
        $this->cache = new FileCache($this->config['cache_directory'] ?? null);
    }
    
    /**
     * Fetch pricing data from remote API
     */
    public function fetchRemotePricing(): ?array
    {
        // Check if remote pricing is enabled
        if (!$this->config['use_remote_pricing']) {
            return null;
        }
        
        // Check cache first
        $cacheKey = 'remote_pricing_data';
        $cached = $this->cache->get($cacheKey);
        
        if ($cached !== null) {
            return $cached;
        }
        
        try {
            // Create a stream context with timeout
            $contextOptions = [
                'http' => [
                    'timeout' => $this->config['timeout'],
                    'ignore_errors' => true,
                ],
            ];
            
            // Disable SSL verification for .test domains (development only)
            if (strpos($this->config['api_endpoint'], '.test/') !== false) {
                $contextOptions['ssl'] = [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ];
            }
            
            $context = stream_context_create($contextOptions);
            
            // Fetch from API
            $response = @file_get_contents($this->config['api_endpoint'], false, $context);
            
            if ($response === false) {
                return null;
            }
            
            $data = json_decode($response, true);
            
            if (!$data || !isset($data['data']['models'])) {
                return null;
            }
            
            $pricingData = $data['data']['models'];
            
            // Cache the data
            $this->cache->put($cacheKey, $pricingData, $this->config['cache_duration']);
            
            return $pricingData;
            
        } catch (\Exception $e) {
            // Silently fail and return null to use local fallback
            return null;
        }
    }
    
    /**
     * Clear the cache
     */
    public function clearCache(): void
    {
        $this->cache->forget('remote_pricing_data');
    }
    
    /**
     * Get default configuration
     */
    private function getDefaultConfig(): array
    {
        // Load from config file if it exists
        $configFile = __DIR__ . '/Config/config.php';
        if (file_exists($configFile)) {
            $fileConfig = include $configFile;
        } else {
            $fileConfig = [];
        }
        
        // Merge with defaults
        return array_merge([
            'api_endpoint' => 'https://vizra.ai/api/v1/pricing/ai-models',
            'cache_duration' => 3600,
            'use_remote_pricing' => true,
            'timeout' => 5,
            'cache_directory' => sys_get_temp_dir() . '/ai-tokens-cache',
        ], $fileConfig);
    }
    
    /**
     * Set configuration option
     */
    public function setConfig(string $key, $value): void
    {
        $this->config[$key] = $value;
    }
    
    /**
     * Get configuration option
     */
    public function getConfig(?string $key = null)
    {
        if ($key === null) {
            return $this->config;
        }
        
        return $this->config[$key] ?? null;
    }
}