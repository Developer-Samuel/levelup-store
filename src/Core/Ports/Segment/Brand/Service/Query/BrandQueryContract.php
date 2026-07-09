<?php

declare(strict_types=1);

namespace App\Core\Ports\Segment\Brand\Service\Query;

use App\Core\Domain\Segment\Brand\Entity\Brand;

interface BrandQueryContract
{
    /**
     * @param int $id
     *
     * @return Brand
    */
    public function getBrandByIdOrFail(int $id): Brand;
}
