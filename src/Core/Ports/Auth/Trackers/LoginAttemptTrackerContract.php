<?php

declare(strict_types=1);

namespace App\Core\Ports\Auth\Trackers;

interface LoginAttemptTrackerContract
{
    /**
     * @return void
    */
    public function trackAttempts(): void;
}
