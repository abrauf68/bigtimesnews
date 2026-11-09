<?php

namespace App\Exceptions\GoogleIndexing;

/** The token is invalid/revoked, or the account has no permission for the property. Not retryable. */
class GoogleAuthException extends GoogleApiException
{
}
