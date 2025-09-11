# AI Tokens

A lightweight PHP package for AI token cost management. Estimate costs before API calls, calculate actual costs from token usage, and track expenses across OpenAI, Claude, Gemini, and other popular AI models.

## Installation

```bash
composer require vizra-ai/ai-tokens
```

## Usage

### 1. Count Tokens & Estimate Cost from Text

Estimate tokens and cost for a text message:

```php
use VizraAi\AiTokens\TokenCounter;

$result = TokenCounter::count('Hello, how are you?', 'gpt-4o');
// Returns: ['input_tokens' => 5, 'estimated_cost' => 0.0000125]
```

### 2. Calculate Actual Cost from Token Usage

Calculate costs when you know the exact token counts (e.g., after an API call):

```php
use VizraAi\AiTokens\TokenCounter;

$result = TokenCounter::calculateActualCost(
    model: 'gpt-4o',
    inputTokens: 500,
    outputTokens: 600
);
// Returns: ['total_cost' => 0.00725, 'input_cost' => 0.00125, 'output_cost' => 0.006]
```

### 3. Estimate Cost Before API Calls

Plan costs before making API calls:

```php
use VizraAi\AiTokens\TokenCounter;

$result = TokenCounter::estimateCost([
    'model' => 'claude-3.5-sonnet',
    'input_tokens' => 2000,
    'expected_output_tokens' => 1500  // optional
]);
// Returns: ['total_cost' => 0.0285, 'input_cost' => 0.006, 'output_cost' => 0.0225]
```

## Supported Models

The package supports 100+ models across major AI providers:

### OpenAI
- GPT-4o series (`gpt-4o`, `gpt-4o-mini`, `gpt-4o-realtime`)
- GPT-4 series (`gpt-4`, `gpt-4-turbo`)
- GPT-3.5 (`gpt-3.5-turbo`)
- ChatGPT models (`chatgpt-4o-latest`, `o1`, `o3` series)

### Claude (Anthropic)
- Claude 3.5 Sonnet (`claude-3-5-sonnet-20241022`)
- Claude 3 series (Opus, Sonnet, Haiku)

### Google
- Gemini 2.0 Flash (`gemini-2.0-flash-exp`, `gemini-2.0-flash-thinking-exp`)
- Gemini 1.5 Pro & Flash series

### Others
- DeepSeek (`deepseek-v3`, `deepseek-r1`, `deepseek-r1-lite`)
- Mistral models
- Llama 3.1 & 3.2 series
- Grok models
- ...and many more

### Utility Methods

```php
// Get all supported models
$models = TokenCounter::getSupportedModels();

// Get model pricing information
$info = TokenCounter::getModelInfo('gpt-4o');
// Returns: ['input_price_per_million' => 2.5, 'output_price_per_million' => 10.0, 'chars_per_token' => 4.0, 'max_tokens' => 128000]

// Get last pricing update date
$date = TokenCounter::getLastUpdated();
// Returns: '2025-01-04'
```

### Exception Handling

```php
use VizraAi\AiTokens\TokenCounter;
use VizraAi\AiTokens\Exceptions\TooManyTokensException;
use InvalidArgumentException;

try {
    $result = TokenCounter::count($longText, 'gpt-3.5-turbo');
} catch (TooManyTokensException $e) {
    // Text exceeds model's token limit
    echo $e->getMessage();
} catch (InvalidArgumentException $e) {
    // Unsupported model name
    echo $e->getMessage();
}
```

## Configuration

The package automatically fetches the latest pricing data from the Vizra AI API. You can configure this behavior:

```php
use VizraAi\AiTokens\Config\Pricing;

// Disable remote pricing (use local data only)
Pricing::configure([
    'use_remote_pricing' => false
]);

// Custom API endpoint
Pricing::configure([
    'api_endpoint' => 'https://your-api.com/pricing',
    'cache_duration' => 7200, // 2 hours
]);

// Clear pricing cache
Pricing::clearCache();
```

### Environment Variables

You can also configure via environment variables:

```bash
# Disable remote pricing fetching
AI_TOKENS_USE_REMOTE=false

# Custom API endpoint
AI_TOKENS_API_ENDPOINT=https://your-api.com/pricing

# Cache duration in seconds (default: 3600)
AI_TOKENS_CACHE_DURATION=7200

# API timeout in seconds (default: 5)
AI_TOKENS_API_TIMEOUT=10
```

## Pricing Updates

Pricing data is automatically fetched from the [Vizra AI Pricing API](https://vizra.ai/ai-llm-model-pricing) which is updated daily. The package includes local fallback data as a backup.

- **Remote Updates**: Fetched automatically (cached for 1 hour)
- **Local Fallback**: Used if API is unavailable
- **Zero Maintenance**: No need to update the package for pricing changes

Last local pricing update: **2025-01-04**

## License

MIT