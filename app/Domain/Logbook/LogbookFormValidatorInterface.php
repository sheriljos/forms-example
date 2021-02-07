<?php

namespace app\Domain\Logbook;

use Symfony\Component\Validator\Constraints as Assert;

interface LogbookFormValidatorInterface
{
    public function getFormConstraints(): Assert\Collection;
}
