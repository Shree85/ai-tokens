<?php

namespace VizraAi\AiTokens\Tests;

use PHPUnit\Framework\TestCase;
use VizraAi\AiTokens\Config\Pricing;

class PricingTest extends TestCase
{
    public function test_get_model_pricing_valid_model(): void
    {
        $pricing = Pricing::getModelPricing('chatgpt-4o');
        
        $this->assertIsArray($pricing);
        $this->assertArrayHasKey('input_price_per_million', $pricing);
        $this->assertArrayHasKey('output_price_per_million', $pricing);
        $this->assertArrayHasKey('chars_per_token', $pricing);
        
        $this->assertIsNumeric($pricing['input_price_per_million']);
        $this->assertIsNumeric($pricing['output_price_per_million']);
        $this->assertIsNumeric($pricing['chars_per_token']);
        
        $this->assertGreaterThan(0, $pricing['input_price_per_million']);
        $this->assertGreaterThan(0, $pricing['output_price_per_million']);
        $this->assertGreaterThan(0, $pricing['chars_per_token']);
    }

    public function test_get_model_pricing_invalid_model(): void
    {
        $pricing = Pricing::getModelPricing('invalid-model');
        
        $this->assertNull($pricing);
    }

    public function test_get_supported_models(): void
    {
        $models = Pricing::getSupportedModels();
        
        $this->assertIsArray($models);
        $this->assertNotEmpty($models);
        
        // Verify some expected models are present
        $expectedModels = [
            'chatgpt-4o-mini',
            'claude-3.5-sonnet',
            'gemini-2.0-flash',
        ];
        
        foreach ($expectedModels as $model) {
            $this->assertContains($model, $models, "Model {$model} should be supported");
        }
    }

    public function test_get_last_updated(): void
    {
        $lastUpdated = Pricing::getLastUpdated();
        
        $this->assertIsString($lastUpdated);
        $this->assertMatchesRegularExpression(
            '/^\d{4}-\d{2}-\d{2}$/',
            $lastUpdated,
            'Last updated should be in YYYY-MM-DD format'
        );
    }

    public function test_pricing_data_consistency(): void
    {
        $models = Pricing::getSupportedModels();
        
        foreach ($models as $model) {
            $pricing = Pricing::getModelPricing($model);
            
            $this->assertIsArray($pricing, "Pricing data for {$model} should be an array");
            
            // Verify required fields exist
            $requiredFields = ['input_price_per_million', 'output_price_per_million', 'chars_per_token'];
            foreach ($requiredFields as $field) {
                $this->assertArrayHasKey($field, $pricing, "Model {$model} should have {$field}");
            }
            
            // Verify data types and reasonable values
            $this->assertIsNumeric($pricing['input_price_per_million']);
            $this->assertIsNumeric($pricing['output_price_per_million']);
            $this->assertIsNumeric($pricing['chars_per_token']);
            
            $this->assertGreaterThan(0, $pricing['input_price_per_million']);
            // Some models (like embedding models) may have 0 output price
            $this->assertGreaterThanOrEqual(0, $pricing['output_price_per_million']);
            $this->assertGreaterThan(1, $pricing['chars_per_token']);
            
            // Verify chars per token is reasonable (between 2 and 6)
            $this->assertGreaterThanOrEqual(2, $pricing['chars_per_token']);
            $this->assertLessThanOrEqual(6, $pricing['chars_per_token']);
        }
    }

    public function test_claude_models_have_correct_chars_per_token(): void
    {
        $models = Pricing::getSupportedModels();
        $claudeModels = array_filter($models, function($model) {
            return str_contains($model, 'claude');
        });
        
        foreach ($claudeModels as $model) {
            $pricing = Pricing::getModelPricing($model);
            $this->assertEquals(3.5, $pricing['chars_per_token'], "Claude model {$model} should have 3.5 chars per token");
        }
    }

    public function test_gpt_models_have_correct_chars_per_token(): void
    {
        $models = Pricing::getSupportedModels();
        $gptModels = array_filter($models, function($model) {
            return str_contains($model, 'gpt') || str_contains($model, 'chatgpt');
        });
        
        foreach ($gptModels as $model) {
            $pricing = Pricing::getModelPricing($model);
            $this->assertEquals(4.0, $pricing['chars_per_token'], "GPT model {$model} should have 4.0 chars per token");
        }
    }
}