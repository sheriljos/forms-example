<?php

namespace app\Domain\Auth;

use Symfony\Component\Validator\Constraints as Assert;

interface LoginFormValidatorInterface
{
    public function getFormConstraints(): Assert\Collection;
}
