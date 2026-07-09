<?php

declare(strict_types=1);

namespace App\Infrastructure\Payment\Stripe;

use Stripe\Stripe;

use App\Core\Ports\Payment\Stripe\StripeSdkContract;

final class StripeSdk implements StripeSdkContract
{
    /**
     * @param string $secretKey
    */
    public function __construct(
        private string $secretKey,
    ) {}

    /**
     * @return void
    */
    public function initialize(): void
    {
        if (empty($this->secretKey) || trim($this->secretKey) === '') {
            throw new \RuntimeException('Stripe secret key is not set.');
        }

        Stripe::setApiKey($this->secretKey);
    }
}
