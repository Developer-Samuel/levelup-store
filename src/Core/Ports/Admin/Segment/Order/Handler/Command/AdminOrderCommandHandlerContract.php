<?php

declare(strict_types=1);

namespace App\Core\Ports\Admin\Segment\Order\Handler\Command;

use App\Core\Domain\Admin\Segment\Order\Payload\AdminOrderStatusPayload;

interface AdminOrderCommandHandlerContract
{
    /**
     * @param AdminOrderStatusPayload $payload
     *
     * @return array<string, mixed>
    */
    public function handle(AdminOrderStatusPayload $payload): array;
}
