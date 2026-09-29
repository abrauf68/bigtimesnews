<?php

namespace App\Contracts\Social;

interface OAuthClientContract
{
    public function authorizeUrl(string $state): string;

    public function exchangeCode(string $code): array;

    public function refresh(string $refreshToken): array;
}
