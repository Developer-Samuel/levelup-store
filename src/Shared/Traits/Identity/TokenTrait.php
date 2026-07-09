<?php

declare(strict_types=1);

namespace App\Shared\Traits\Identity;

/**
 * @property string $token
*/
trait TokenTrait
{
    private string $token;

    /**
     * @return string
    */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     * 
     * @return self
    */
    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }
}
