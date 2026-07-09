<?php

declare(strict_types=1);

namespace App\Core\Ports\Segment\User\Trackers;

interface ChangePasswordAttemptTrackerContract
{
    /**
     * @return void
    */
    public function trackAttempts(): void;
}
