<?php

declare(strict_types=1);

namespace App\Infrastructure\Auth\Trackers;

use App\Core\Ports\{
    Auth\Trackers\ForgotPasswordAttemptTrackerContract,
    Shared\Proxy\SessionProxyContract
};

use App\Infrastructure\Abstract\Trackers\AbstractAttemptTracker;

class ForgotPasswordAttemptTracker extends AbstractAttemptTracker implements ForgotPasswordAttemptTrackerContract
{
    /**
     * @param SessionProxyContract $sessionProxy
    */
    public function __construct(SessionProxyContract $sessionProxy) {
        parent::__construct(
            sessionProxy: $sessionProxy,
            attemptsSessionKey: 'forgot_password_attempts',
            lastAttemptSessionKey: 'last_forgot_password_attempt',
        );
    }
}
