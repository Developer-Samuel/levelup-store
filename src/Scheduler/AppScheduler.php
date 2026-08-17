<?php

declare(strict_types=1);

namespace App\Scheduler;

use Symfony\{
    Component\Scheduler\Attribute\AsSchedule,
    Component\Scheduler\RecurringMessage,
    Component\Scheduler\Schedule,
    Component\Scheduler\ScheduleProviderInterface,
    Contracts\Cache\CacheInterface
};

use App\Scheduler\{
    Message\Cart\CartCleanupMessage,
    Message\Cart\CartReminderMessage,
    Message\Cart\CartStockCleanupMessage,
    Message\Country\CountrySyncMessage,
    Message\Product\ProductRecommendedSyncMessage,
    Message\Product\ProductEanSyncMessage,
    Message\Product\ProductStockSyncMessage,
    Message\Token\TokenCleanupMessage
};

#[AsSchedule]
class AppScheduler implements ScheduleProviderInterface
{
    /**
     * @param CacheInterface $cache
    */
    public function __construct(
        private CacheInterface $cache,
    ) {}

    /**
     * @return Schedule
    */
    public function getSchedule(): Schedule
    {
        return (new Schedule())
            ->stateful($this->cache)
            ->processOnlyLastMissedRun(true)
            ->add(...$this->buildMessages());
    }

    /**
     * @return RecurringMessage[]
    */
    private function buildMessages(): array
    {
        return [
            // Cart
            RecurringMessage::cron('0 0 * * *', new CartCleanupMessage()),
            RecurringMessage::every('15 minutes', new CartStockCleanupMessage()),
            RecurringMessage::every('15 minutes', new CartReminderMessage()),

            // Product
            RecurringMessage::every('15 minutes', new ProductEanSyncMessage()),
            RecurringMessage::every('15 minutes', new ProductStockSyncMessage()),
            RecurringMessage::every('15 minutes', new ProductRecommendedSyncMessage()),

            // Token
            RecurringMessage::every('1 hours', new TokenCleanupMessage()),

            // Country
            RecurringMessage::cron('0 2 1 * *', new CountrySyncMessage()),
        ];
    }
}
