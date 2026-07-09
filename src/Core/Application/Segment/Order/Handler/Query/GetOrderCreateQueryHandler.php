<?php

declare(strict_types=1);

namespace App\Core\Application\Segment\Order\Handler\Query;

use App\Core\Domain\{
    Exception\AccessDeniedException,
    Segment\Cart\Entity\Cart,
    Segment\Order\Enum\OrderPaymentMethod,
    Segment\Order\ValueObject\OrderCreateObject,
    Segment\User\Entity\User
};

use App\Core\Ports\{
    Security\Provider\SecurityProviderContract,
    Segment\Cart\Service\Query\CartControlQueryContract,
    Segment\Country\Service\Query\CountryCacheQueryContract,
    Segment\Order\Handler\Query\GetOrderCreateQueryHandlerContract
};

final readonly class GetOrderCreateQueryHandler implements GetOrderCreateQueryHandlerContract
{
    /**
     * @param SecurityProviderContract $securityProvider
     * @param CountryCacheQueryContract $countryCacheQuery
     * @param CartControlQueryContract $cartControlQuery
    */
    public function __construct(
        private SecurityProviderContract $securityProvider,
        private CountryCacheQueryContract $countryCacheQuery,
        private CartControlQueryContract $cartControlQuery,
    ) {}

    /**
     * @return OrderCreateObject
     *
     * @throws AccessDeniedException
    */
    public function handle(): OrderCreateObject
    {
        $user = $this->securityProvider->getCurrentUser();
        if ($user === null) {
            throw new AccessDeniedException();
        }

        $cart = $this->getUserCart($user);
        $cartEmpty = $this->isCartEmpty($cart);

        return new OrderCreateObject(
            personal: $user,
            countries: $this->countryCacheQuery->getAllCountries(),
            paymentMethods: OrderPaymentMethod::cases(),
            cartEmpty: $cartEmpty,
            useShipping: $user->getUseShipping(),
            billing: $user->getBilling(),
            shipping: $user->getShipping(),
        );
    }

    /**
     * @param User|null $user
     *
     * @return Cart|null
    */
    private function getUserCart(?User $user): ?Cart
    {
        if ($user === null) {
            return null;
        }

        return $this->cartControlQuery->getUserCart($user);
    }

    /**
     * @param Cart|null $cart
     *
     * @return bool
    */
    private function isCartEmpty(?Cart $cart): bool
    {
        if ($cart === null) {
            return true;
        }

        $items = $cart->getItems()->toArray();

        return empty($items);
    }
}
