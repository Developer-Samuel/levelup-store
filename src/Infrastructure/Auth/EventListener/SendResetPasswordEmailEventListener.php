<?php

declare(strict_types=1);

namespace App\Infrastructure\Auth\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

use App\Core\Domain\Auth\Event\ResetPasswordCompletedEvent;

use App\Infrastructure\Auth\Email\ResetPasswordEmail;

#[AsEventListener(event: ResetPasswordCompletedEvent::class)]
final readonly class SendResetPasswordEmailEventListener
{
    /**
     * @param ResetPasswordEmail $resetPasswordEmail
    */
    public function __construct(
        private ResetPasswordEmail $resetPasswordEmail,
    ) {}

    /**
     * @param ResetPasswordCompletedEvent $event
     *
     * @return void
    */
    public function __invoke(ResetPasswordCompletedEvent $event): void
    {
        $this->resetPasswordEmail->send(
            $event->user->getEmail(),
            $event->user,
        );
    }
}
