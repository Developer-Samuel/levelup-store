<?php

declare(strict_types=1);

namespace App\Core\Domain\Shared\Exception;

class ConflictException extends \RuntimeException
{
    protected int $statusCode = 409;

    /**
     * @param string $message
    */
    public function __construct(
        string $message = 'Conflict occurred.',
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
