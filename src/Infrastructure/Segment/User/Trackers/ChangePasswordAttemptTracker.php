<?php

declare(strict_types=1);

namespace App\Infrastructure\Segment\User\Trackers;

use App\Core\Ports\{
    Segment\User\Trackers\ChangePasswordAttemptTrackerContract,
    Shared\Proxy\SessionProxyContract
};

use App\Infrastructure\Abstract\Trackers\AbstractAttemptTracker;

class ChangePasswordAttemptTracker extends AbstractAttemptTracker implements ChangePasswordAttemptTrackerContract
{
    /**
     * @param SessionProxyContract $sessionProxy
    */
    public function __construct(SessionProxyContract $sessionProxy) {
        parent::__construct(
            sessionProxy: $sessionProxy,
            attemptsSessionKey: 'change_password_attempts',
            lastAttemptSessionKey: 'last_change_password_attempt',
        );
    }
}
