<?php

declare(strict_types=1);

namespace App\Core\Domain\Exception;

class NotFoundException extends \Exception
{
    protected int $statusCode = 404;

    /**
     * @param string $message
    */
    public function __construct(
        string $message = 'Resource not found.',
    ) {
        parent::__construct($message);
    }

    /**
     * @return int
    */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
