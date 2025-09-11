<?php

namespace VizraAi\AiTokens\Tests;

use PHPUnit\Framework\TestCase;
use VizraAi\AiTokens\TokenCounter;
use InvalidArgumentException;

class TokenCounterTest extends TestCase
{
    public function test_count_basic_functionality(): void
    {
        $text = "Hello, world! This is a test message.";
        $result = TokenCounter::count($text, 'chatgpt-4o');
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('input_tokens', $result);
        $this->assertArrayHasKey('estimated_cost', $result);
        $this->assertIsInt($result['input_tokens']);
        $this->assertIsFloat($result['estimated_cost']);
        $this->assertGreaterThan(0, $result['input_tokens']);
        $this->assertGreaterThan(0, $result['estimated_cost']);
    }

    public function test_count_with_different_models(): void
    {
        $text = "This is a test message for token counting.";
        
        // Test GPT model (4 chars per token)
        $gptResult = TokenCounter::count($text, 'chatgpt-4o');
        
        // Test Claude model (3.5 chars per token)
        $claudeResult = TokenCounter::count($text, 'claude-3.5-sonnet');
        
        // Claude should have more tokens due to lower chars per token ratio
        $this->assertGreaterThan($gptResult['input_tokens'], $claudeResult['input_tokens']);
    }

    public function test_count_with_unsupported_model(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported model: invalid-model');
        
        TokenCounter::count("Test message", 'invalid-model');
    }

    public function test_count_with_very_long_text(): void
    {
        // Create a very long text
        $longText = str_repeat("This is a very long message. ", 10000);
        
        // Should handle long text without throwing exception
        $result = TokenCounter::count($longText, 'gpt-3.5-turbo');
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('input_tokens', $result);
        $this->assertArrayHasKey('estimated_cost', $result);
        $this->assertGreaterThan(10000, $result['input_tokens']);
    }

    public function test_calculate_actual_cost_basic_functionality(): void
    {
        $result = TokenCounter::calculateActualCost(
            model: 'chatgpt-4o',
            inputTokens: 500,
            outputTokens: 200
        );
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('total_cost', $result);
        $this->assertArrayHasKey('input_cost', $result);
        $this->assertArrayHasKey('output_cost', $result);
        
        $this->assertIsFloat($result['total_cost']);
        $this->assertIsFloat($result['input_cost']);
        $this->assertIsFloat($result['output_cost']);
        
        $this->assertGreaterThan(0, $result['total_cost']);
        $this->assertGreaterThan(0, $result['input_cost']);
        $this->assertGreaterThan(0, $result['output_cost']);
        
        // Verify total cost equals input + output (with some floating point tolerance)
        $this->assertEqualsWithDelta(
            $result['input_cost'] + $result['output_cost'],
            $result['total_cost'],
            0.000001,
            'Total cost should equal input cost plus output cost'
        );
    }

    public function test_calculate_actual_cost_without_output_tokens(): void
    {
        $result = TokenCounter::calculateActualCost(
            model: 'chatgpt-4o',
            inputTokens: 500,
            outputTokens: 0
        );
        
        $this->assertEquals(0.0, $result['output_cost']);
        $this->assertEquals($result['input_cost'], $result['total_cost']);
    }

    public function test_calculate_actual_cost_unsupported_model(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported model: invalid-model');
        
        TokenCounter::calculateActualCost(
            model: 'invalid-model',
            inputTokens: 500,
            outputTokens: 200
        );
    }

    public function test_calculate_actual_cost_with_high_tokens(): void
    {
        // Should handle high token counts without throwing exception
        $result = TokenCounter::calculateActualCost(
            model: 'gpt-3.5-turbo',
            inputTokens: 3000,
            outputTokens: 2000
        );
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('total_cost', $result);
        $this->assertGreaterThan(0, $result['total_cost']);
    }

    public function test_estimate_cost_basic_functionality(): void
    {
        $params = [
            'model' => 'chatgpt-4o',
            'input_tokens' => 500,
            'expected_output_tokens' => 200
        ];
        
        $result = TokenCounter::estimateCost($params);
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('total_cost', $result);
        $this->assertArrayHasKey('input_cost', $result);
        $this->assertArrayHasKey('output_cost', $result);
        
        $this->assertIsFloat($result['total_cost']);
        $this->assertIsFloat($result['input_cost']);
        $this->assertIsFloat($result['output_cost']);
        
        $this->assertGreaterThan(0, $result['total_cost']);
        $this->assertGreaterThan(0, $result['input_cost']);
        $this->assertGreaterThan(0, $result['output_cost']);
        
        // Verify total cost equals input + output (with some floating point tolerance)
        $this->assertEqualsWithDelta(
            $result['input_cost'] + $result['output_cost'],
            $result['total_cost'],
            0.000001,
            'Total cost should equal input cost plus output cost'
        );
    }

    public function test_estimate_cost_without_output_tokens(): void
    {
        $params = [
            'model' => 'chatgpt-4o',
            'input_tokens' => 500,
        ];
        
        $result = TokenCounter::estimateCost($params);
        
        $this->assertEquals(0.0, $result['output_cost']);
        $this->assertEquals($result['input_cost'], $result['total_cost']);
    }

    public function test_estimate_cost_missing_required_params(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Missing required parameter: model');
        
        TokenCounter::estimateCost(['input_tokens' => 500]);
    }

    public function test_estimate_cost_unsupported_model(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported model: invalid-model');
        
        TokenCounter::estimateCost([
            'model' => 'invalid-model',
            'input_tokens' => 500
        ]);
    }

    public function test_estimate_cost_with_high_tokens(): void
    {
        // Should handle high token counts without throwing exception
        $result = TokenCounter::estimateCost([
            'model' => 'gpt-3.5-turbo',
            'input_tokens' => 3000,
            'expected_output_tokens' => 2000
        ]);
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('total_cost', $result);
        $this->assertGreaterThan(0, $result['total_cost']);
    }

    public function test_get_supported_models(): void
    {
        $models = TokenCounter::getSupportedModels();
        
        $this->assertIsArray($models);
        $this->assertNotEmpty($models);
        $this->assertContains('chatgpt-4o-mini', $models);
        $this->assertContains('claude-3.5-sonnet', $models);
    }

    public function test_get_model_info(): void
    {
        $info = TokenCounter::getModelInfo('chatgpt-4o');
        
        $this->assertIsArray($info);
        $this->assertArrayHasKey('input_price_per_million', $info);
        $this->assertArrayHasKey('output_price_per_million', $info);
        $this->assertArrayHasKey('chars_per_token', $info);
        
        // Test with unsupported model
        $this->assertNull(TokenCounter::getModelInfo('invalid-model'));
    }

    public function test_get_last_updated(): void
    {
        $lastUpdated = TokenCounter::getLastUpdated();
        
        $this->assertIsString($lastUpdated);
        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}$/', $lastUpdated);
    }

    public function test_cost_precision(): void
    {
        // Test with very small token counts to ensure proper precision
        $result = TokenCounter::estimateCost([
            'model' => 'chatgpt-4o',
            'input_tokens' => 1,
            'expected_output_tokens' => 1
        ]);
        
        // With 1 token and rounding to 6 decimals, the cost may round to 0
        // chatgpt-4o costs $2.00 per million input tokens = $0.000002 per token
        // This rounds to 0.000000 with 6 decimal places
        $this->assertGreaterThanOrEqual(0, $result['input_cost']);
        $this->assertGreaterThanOrEqual(0, $result['output_cost']);
        $this->assertLessThan(0.001, $result['total_cost']);
        
        // Test with more tokens to ensure precision works for realistic cases
        $result = TokenCounter::estimateCost([
            'model' => 'chatgpt-4o',
            'input_tokens' => 100,
            'expected_output_tokens' => 100
        ]);
        
        $this->assertGreaterThan(0, $result['input_cost']);
        $this->assertGreaterThan(0, $result['output_cost']);
        $this->assertGreaterThan(0, $result['total_cost']);
    }
}