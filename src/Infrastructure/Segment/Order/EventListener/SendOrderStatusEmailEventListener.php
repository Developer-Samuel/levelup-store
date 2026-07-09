<?php

declare(strict_types=1);

namespace App\Infrastructure\Segment\Order\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

use App\Core\Domain\Segment\Order\Event\OrderStatusChangedEvent;

use App\Infrastructure\Segment\Order\Email\OrderStatusEmail;

#[AsEventListener(event: OrderStatusChangedEvent::class)]
final readonly class SendOrderStatusEmailEventListener
{
    /**
     * @param OrderStatusEmail $orderStatusEmail
    */
    public function __construct(
        private OrderStatusEmail $orderStatusEmail,
    ) {}

    /**
     * @param OrderStatusChangedEvent $event
     *
     * @return void
    */
    public function __invoke(OrderStatusChangedEvent $event): void
    {
        $personal = $event->order->getPersonal();
        if (!$personal) {
            return;
        }

        $email = $personal->getEmail();
        if (!$email) {
            return;
        }

        $this->orderStatusEmail->send($email, $event->order);
    }
}
