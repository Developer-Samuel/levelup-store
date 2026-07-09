<?php

declare(strict_types=1);

namespace App\Core\Ports\Auth\Trackers;

interface ForgotPasswordAttemptTrackerContract
{
    /**
     * @return void
    */
    public function trackAttempts(): void;
}
