<?php

declare(strict_types=1);

namespace App\Core\Application\Shared\Input;

use App\Core\Application\{
    Shared\Constraint\Length\MinLengthConstraint,
    Shared\Constraint\Length\MaxLengthConstraint,
    Shared\Constraint\NotBlankConstraint
};

trait NameFields
{
    #[NotBlankConstraint('First name')]
    #[MinLengthConstraint('First name', 2)]
    #[MaxLengthConstraint('First name', 100)]
    public string $first_name;

    #[NotBlankConstraint('Last name')]
    #[MinLengthConstraint('Last name', 2)]
    #[MaxLengthConstraint('Last name', 100)]
    public string $last_name;
}
