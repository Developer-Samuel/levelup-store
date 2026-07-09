<?php

declare(strict_types=1);

namespace App\Core\Domain\Exception;

class TooManyRequestsException extends \Exception
{
    protected int $statusCode = 429;

    /**
     * @param string $message
    */
    public function __construct(
        string $message = 'Too many attempts, please try again in a moment.',
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
