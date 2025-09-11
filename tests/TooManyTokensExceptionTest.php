<?php

namespace VizraAi\AiTokens\Tests;

use PHPUnit\Framework\TestCase;
use VizraAi\AiTokens\Exceptions\TooManyTokensException;

class TooManyTokensExceptionTest extends TestCase
{
    public function test_basic_exception(): void
    {
        $exception = new TooManyTokensException('Custom message');
        
        $this->assertInstanceOf(TooManyTokensException::class, $exception);
        $this->assertEquals('Custom message', $exception->getMessage());
    }

    public function test_default_message(): void
    {
        $exception = new TooManyTokensException();
        
        $this->assertEquals('Token limit exceeded', $exception->getMessage());
    }

    public function test_exception_with_token_details(): void
    {
        $exception = new TooManyTokensException('', 5000, 4096, 'gpt-3.5-turbo');
        
        $expectedMessage = 'Token limit exceeded for model "gpt-3.5-turbo": 5000 tokens (max: 4096)';
        $this->assertEquals($expectedMessage, $exception->getMessage());
    }

    public function test_for_model_static_method(): void
    {
        $exception = TooManyTokensException::forModel('gpt-4', 10000, 8192);
        
        $expectedMessage = 'Token limit exceeded for model "gpt-4": 10000 tokens (max: 8192)';
        $this->assertEquals($expectedMessage, $exception->getMessage());
    }

    public function test_exception_inheritance(): void
    {
        $exception = new TooManyTokensException();
        
        $this->assertInstanceOf(\Exception::class, $exception);
        $this->assertInstanceOf(\Throwable::class, $exception);
    }
}