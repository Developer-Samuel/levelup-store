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
    Message\Country\CountrySyncMessage,
    Message\Product\ProductVariantEanSyncMessage,
    Message\Product\ProductVariantStockSyncMessage,
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
            RecurringMessage::cron('0 2 1 * *', new CountrySyncMessage()),
            RecurringMessage::every('15 minutes', new ProductVariantEanSyncMessage()),
            RecurringMessage::every('15 minutes', new ProductVariantStockSyncMessage()),
            RecurringMessage::every('1 hours', new TokenCleanupMessage()),
        ];
    }
}
