<?php

declare(strict_types=1);

namespace App\Infrastructure\Segment\User\Trackers;

use App\Core\Ports\{
    Segment\User\Trackers\ProfileAttemptTrackerContract,
    Shared\Proxy\SessionProxyContract
};

use App\Infrastructure\Abstract\Trackers\AbstractAttemptTracker;

class ProfileAttemptTracker extends AbstractAttemptTracker implements ProfileAttemptTrackerContract
{
    /**
     * @param SessionProxyContract $sessionProxy
    */
    public function __construct(SessionProxyContract $sessionProxy) {
        parent::__construct(
            sessionProxy: $sessionProxy,
            attemptsSessionKey: 'profile_attempts',
            lastAttemptSessionKey: 'last_profile_attempt',
        );
    }
}
