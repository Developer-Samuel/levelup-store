<?php

declare(strict_types=1);

namespace App\Core\Application\Segment\Order\Handler\Command;

use App\Core\Domain\{
    Segment\Order\Payload\OrderCreatePayload,
    Segment\Order\Entity\Order
};

use App\Core\Application\Abstract\Handler\AbstractCommandHandler;

use App\Core\Ports\{
    Security\Policy\SecurityPolicyContract,
    Segment\Order\Handler\Command\CreateOrderHandlerContract,
    Segment\Order\Service\Command\OrderMutationCommandContract,
    Shared\Logging\AppLoggerContract
};

use App\Shared\Utils\Formatter\ApiResultFormatter;

class CreateOrderHandler extends AbstractCommandHandler implements CreateOrderHandlerContract
{
    /**
     * @param SecurityPolicyContract $securityPolicy
     * @param OrderMutationCommandContract $orderMutationCommand
     * @param AppLoggerContract $logger
    */
    public function __construct(
        private readonly SecurityPolicyContract $securityPolicy,
        private readonly OrderMutationCommandContract $orderMutationCommand,
        AppLoggerContract $logger,
    ) {
        parent::__construct($logger);
    }

    /**
     * @param OrderCreatePayload $payload
     *
     * @return array<string, mixed>
    */
    public function handle(OrderCreatePayload $payload): array
    {
        return $this->execute(function () use ($payload) {
            $this->securityPolicy->checkIfEmailVerified();

            $result = $this->orderMutationCommand->createOrder($payload);

            if ($result->order !== null) {
                $this->logOrderCreated($result->order);

                return ApiResultFormatter::success('Order created successfully', null, 'success');
            }

            return ApiResultFormatter::success('Payment redirect successful', null, $result->paymentUrl);
        });
    }

    /**
     * @param Order $order
     *
     * @return void
    */
    private function logOrderCreated(Order $order): void
    {
        $user = $order->getUser();

        $this->logger->info('Order created successfully', $user, [
            'order_id' => $order->getId(),
        ]);
    }
}
