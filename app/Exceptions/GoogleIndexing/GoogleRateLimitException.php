<?php

namespace App\Exceptions\GoogleIndexing;

/** HTTP 429 / quota exceeded. The job should be released and retried later. */
class GoogleRateLimitException extends GoogleApiException
{
}
