<?php

namespace VizraAi\AiTokens\Exceptions;

use Exception;

class TooManyTokensException extends Exception
{
    public function __construct(
        string $message = 'Token limit exceeded',
        int $actualTokens = 0,
        int $maxTokens = 0,
        string $model = '',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        if ($actualTokens > 0 && $maxTokens > 0) {
            $message = sprintf(
                'Token limit exceeded for model "%s": %d tokens (max: %d)',
                $model,
                $actualTokens,
                $maxTokens
            );
        }

        parent::__construct($message, $code, $previous);
    }

    public static function forModel(string $model, int $actualTokens, int $maxTokens): self
    {
        return new self('', $actualTokens, $maxTokens, $model);
    }
}