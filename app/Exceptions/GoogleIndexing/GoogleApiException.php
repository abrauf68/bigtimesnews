<?php

namespace App\Exceptions\GoogleIndexing;

use RuntimeException;

/** Generic Google API failure (retryable unless it is one of the subclasses below). */
class GoogleApiException extends RuntimeException
{
    public function __construct(string $message, public readonly ?int $status = null)
    {
        parent::__construct($message);
    }
}
