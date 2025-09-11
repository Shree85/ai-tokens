<?php

namespace VizraAi\AiTokens;

use VizraAi\AiTokens\Config\Pricing;
use InvalidArgumentException;

class TokenCounter
{
    public static function count(string $text, string $model): array
    {
        $modelPricing = Pricing::getModelPricing($model);
        
        if ($modelPricing === null) {
            throw new InvalidArgumentException("Unsupported model: {$model}");
        }

        $charsPerToken = $modelPricing['chars_per_token'];
        $inputPricePerMillion = $modelPricing['input_price_per_million'];

        // Estimate tokens based on character count
        $inputTokens = (int) ceil(mb_strlen($text) / $charsPerToken);

        // Calculate estimated cost
        $estimatedCost = ($inputTokens / 1_000_000) * $inputPricePerMillion;

        return [
            'input_tokens' => $inputTokens,
            'estimated_cost' => round($estimatedCost, 6),
        ];
    }

    public static function calculateActualCost(
        string $model,
        int $inputTokens,
        int $outputTokens = 0
    ): array {
        $modelPricing = Pricing::getModelPricing($model);
        
        if ($modelPricing === null) {
            throw new InvalidArgumentException("Unsupported model: {$model}");
        }

        $inputPricePerMillion = $modelPricing['input_price_per_million'];
        $outputPricePerMillion = $modelPricing['output_price_per_million'];

        // Calculate costs
        $inputCost = ($inputTokens / 1_000_000) * $inputPricePerMillion;
        $outputCost = ($outputTokens / 1_000_000) * $outputPricePerMillion;
        $totalCost = $inputCost + $outputCost;

        return [
            'total_cost' => round($totalCost, 6),
            'input_cost' => round($inputCost, 6),
            'output_cost' => round($outputCost, 6),
        ];
    }

    public static function estimateCost(array $params): array
    {
        $requiredKeys = ['model', 'input_tokens'];
        foreach ($requiredKeys as $key) {
            if (!isset($params[$key])) {
                throw new InvalidArgumentException("Missing required parameter: {$key}");
            }
        }

        $model = $params['model'];
        $inputTokens = $params['input_tokens'];
        $outputTokens = $params['expected_output_tokens'] ?? 0;

        $modelPricing = Pricing::getModelPricing($model);
        
        if ($modelPricing === null) {
            throw new InvalidArgumentException("Unsupported model: {$model}");
        }

        $inputPricePerMillion = $modelPricing['input_price_per_million'];
        $outputPricePerMillion = $modelPricing['output_price_per_million'];

        // Calculate costs
        $inputCost = ($inputTokens / 1_000_000) * $inputPricePerMillion;
        $outputCost = ($outputTokens / 1_000_000) * $outputPricePerMillion;
        $totalCost = $inputCost + $outputCost;

        return [
            'total_cost' => round($totalCost, 6),
            'input_cost' => round($inputCost, 6),
            'output_cost' => round($outputCost, 6),
        ];
    }

    public static function getSupportedModels(): array
    {
        return Pricing::getSupportedModels();
    }

    public static function getModelInfo(string $model): ?array
    {
        return Pricing::getModelPricing($model);
    }

    public static function getLastUpdated(): string
    {
        return Pricing::getLastUpdated();
    }
}