<?php

namespace VizraAi\AiTokens\Cache;

class FileCache
{
    private string $cacheDir;
    
    public function __construct(?string $cacheDir = null)
    {
        $this->cacheDir = $cacheDir ?: sys_get_temp_dir() . '/ai-tokens-cache';
        
        // Ensure cache directory exists
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }
    
    /**
     * Get a value from cache
     */
    public function get(string $key, $default = null)
    {
        $filePath = $this->getCachePath($key);
        
        if (!file_exists($filePath)) {
            return $default;
        }
        
        $content = file_get_contents($filePath);
        $data = json_decode($content, true);
        
        if (!$data || !isset($data['expires_at'])) {
            return $default;
        }
        
        // Check if cache has expired
        if (time() > $data['expires_at']) {
            unlink($filePath);
            return $default;
        }
        
        return $data['value'];
    }
    
    /**
     * Store a value in cache
     */
    public function put(string $key, $value, int $seconds): bool
    {
        $filePath = $this->getCachePath($key);
        
        $data = [
            'value' => $value,
            'expires_at' => time() + $seconds,
        ];
        
        $content = json_encode($data);
        
        return file_put_contents($filePath, $content) !== false;
    }
    
    /**
     * Remove a value from cache
     */
    public function forget(string $key): bool
    {
        $filePath = $this->getCachePath($key);
        
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        
        return true;
    }
    
    /**
     * Clear all cache
     */
    public function flush(): bool
    {
        $files = glob($this->cacheDir . '/*.cache');
        
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        
        return true;
    }
    
    /**
     * Clean up expired cache files
     */
    public function cleanup(): void
    {
        $files = glob($this->cacheDir . '/*.cache');
        
        foreach ($files as $file) {
            if (!is_file($file)) {
                continue;
            }
            
            $content = file_get_contents($file);
            $data = json_decode($content, true);
            
            if (!$data || !isset($data['expires_at'])) {
                unlink($file);
                continue;
            }
            
            if (time() > $data['expires_at']) {
                unlink($file);
            }
        }
    }
    
    /**
     * Get the cache file path for a given key
     */
    private function getCachePath(string $key): string
    {
        return $this->cacheDir . '/' . md5($key) . '.cache';
    }
}