<?php

declare(strict_types=1);

namespace App\Core\Domain\Shared\Traits\State;

/**
 * @property \DateTimeImmutable $expiresAt
*/
trait ExpiresTrait
{
    /**
     * @return \DateTimeImmutable|null
    */
    public function getExpiresAt(): ?\DateTimeImmutable
    {
        return $this->expiresAt;
    }

    /**
     * @param \DateTimeImmutable|null $expiresAt
     *
     * @return self
    */
    public function setExpiresAt(?\DateTimeImmutable $expiresAt): self
    {
        $this->expiresAt = $expiresAt;
        return $this;
    }
}
