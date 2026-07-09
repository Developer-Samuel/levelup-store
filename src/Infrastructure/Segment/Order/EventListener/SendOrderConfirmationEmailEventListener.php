<?php

declare(strict_types=1);

namespace App\Infrastructure\Segment\Order\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

use App\Core\Domain\Segment\Order\Event\OrderConfirmationRequestedEvent;

use App\Infrastructure\Segment\Order\Email\OrderConfirmationEmail;

#[AsEventListener(event: OrderConfirmationRequestedEvent::class)]
final readonly class SendOrderConfirmationEmailEventListener
{
    /**
     * @param OrderConfirmationEmail $orderConfirmationEmail
    */
    public function __construct(
        private OrderConfirmationEmail $orderConfirmationEmail,
    ) {}

    /**
     * @param OrderConfirmationRequestedEvent $event
     *
     * @return void
    */
    public function __invoke(OrderConfirmationRequestedEvent $event): void
    {
        $this->orderConfirmationEmail->send(
            $event->personal->getEmail(),
            $event->order,
            $event->personal,
            $event->billing,
            $event->shipping,
            $event->items,
        );
    }
}
