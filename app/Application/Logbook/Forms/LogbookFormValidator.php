<?php

declare(strict_types=1);

namespace app\Application\Logbook\Forms;

use lib\FormValidator;
use app\Domain\Logbook\LogbookFormValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class LogbookFormValidator extends FormValidator implements LogbookFormValidatorInterface
{
    public function getFormConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'name' => new Assert\Length(['min' => 5]),
            'description' => new Assert\Length(['min' => 5])
        ]);
    }
}
