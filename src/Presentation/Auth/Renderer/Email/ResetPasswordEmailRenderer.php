<?php

declare(strict_types=1);

namespace App\Presentation\Auth\Renderer\Email;

use Twig\Environment;

use App\Core\Domain\Segment\User\Entity\User;

use App\Core\Ports\Auth\Renderer\Email\ResetPasswordEmailRendererContract;

final readonly class ResetPasswordEmailRenderer implements ResetPasswordEmailRendererContract
{
    /**
     * @param Environment $twig
    */
    public function __construct(
        private Environment $twig,
    ) {}

    /**
     * @param User $user
     *
     * @return string
    */
    public function renderResetPasswordEmail(User $user): string
    {
        return $this->twig->render(
            'emails/password/reset-password.html.twig',
            ['user' => $user],
        );
    }
}
