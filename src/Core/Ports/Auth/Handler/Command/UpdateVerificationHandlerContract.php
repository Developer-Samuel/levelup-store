<?php

declare(strict_types=1);

namespace App\Core\Ports\Auth\Handler\Command;

use App\Core\Domain\Auth\Payload\UpdateVerificationPayload;

interface UpdateVerificationHandlerContract
{
    /**
     * @param UpdateVerificationPayload $payload
     *
     * @return bool
    */
    public function handle(UpdateVerificationPayload $payload): bool;
}
