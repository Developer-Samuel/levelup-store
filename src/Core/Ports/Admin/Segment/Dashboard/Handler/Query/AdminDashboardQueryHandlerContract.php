<?php

declare(strict_types=1);

namespace App\Core\Ports\Admin\Segment\Dashboard\Handler\Query;

interface AdminDashboardQueryHandlerContract
{
    /**
     * @return array<string, int[]>
    */
    public function handle(): array;
}
