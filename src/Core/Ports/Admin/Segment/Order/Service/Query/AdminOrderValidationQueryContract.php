<?php

declare(strict_types=1);

namespace App\Core\Ports\Admin\Segment\Order\Service\Query;

use App\Core\Domain\{
    Admin\Segment\Order\Payload\AdminOrderStatusPayload,
    Segment\Order\Entity\Order
};

interface AdminOrderValidationQueryContract
{
    /**
     * @param Order $order
     * @param AdminOrderStatusPayload $payload
     *
     * @return void
     *
     * @throws \RuntimeException
    */
    public function checkSameStatus(Order $order, AdminOrderStatusPayload $payload): void;

    /**
     * @param Order $order
     *
     * @return void
     *
     * @throws \RuntimeException
    */
    public function checkRefundedStatus(Order $order): void;

    /**
     * @param Order $order
     * @param AdminOrderStatusPayload $payload
     *
     * @return void
     *
     * @throws \RuntimeException
    */
    public function checkCompletedStatus(Order $order, AdminOrderStatusPayload $payload): void;
}
