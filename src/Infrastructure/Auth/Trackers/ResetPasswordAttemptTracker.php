<?php

declare(strict_types=1);

namespace App\Infrastructure\Auth\Trackers;

use App\Core\Ports\{
    Auth\Trackers\ResetPasswordAttemptTrackerContract,
    Shared\Proxy\SessionProxyContract
};

use App\Infrastructure\Abstract\Trackers\AbstractAttemptTracker;

class ResetPasswordAttemptTracker extends AbstractAttemptTracker implements ResetPasswordAttemptTrackerContract
{
    /**
     * @param SessionProxyContract $sessionProxy
    */
    public function __construct(SessionProxyContract $sessionProxy) {
        parent::__construct(
            sessionProxy: $sessionProxy,
            attemptsSessionKey: 'reset_password_attempts',
            lastAttemptSessionKey: 'last_reset_password_attempt',
        );
    }
}
