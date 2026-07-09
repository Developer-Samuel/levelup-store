<?php

declare(strict_types=1);

namespace App\Core\Ports\Search\Service\Query;

interface SearchQueryContract
{
    /**
     * @param string $query
     *
     * @return array<int, array<string, mixed>>
    */
    public function searchByTerm(string $query): array;
}
