<?php

declare(strict_types=1);

namespace App\Core\Application\Abstract\Handler;

use App\Core\Domain\Exception\TooManyRequestsException;

use App\Core\Ports\Shared\Logging\AppLoggerContract;

use App\Shared\Utils\Formatter\ApiResultFormatter;

abstract class AbstractRateLimitHandler extends AbstractCommandHandler
{
    /**
     * @param AppLoggerContract $logger
    */
    public function __construct(AppLoggerContract $logger) {
        parent::__construct($logger);
    }

    /**
     * @template T of array<string, mixed>
     *
     * @param object $tracker
     * @param callable(): T $callback
     *
     * @return T|array<string, mixed>
    */
    protected function executeRateLimit(object $tracker, callable $callback): array
    {
        return $this->execute(function () use ($tracker, $callback) {
            try {
                $this->assertRateLimit($tracker);
            } catch (TooManyRequestsException $tooManyRequestsException) {
                return ApiResultFormatter::error(429, $tooManyRequestsException->getMessage());
            }

            return $callback();
        });
    }

    /**
     * @param object $tracker
     *
     * @return void
     *
     * @throws TooManyRequestsException
    */
    private function assertRateLimit(object $tracker): void
    {
        if (property_exists($tracker, 'tooManyAttempts') && $tracker->tooManyAttempts) {
            throw new TooManyRequestsException();
        }
    }
}
