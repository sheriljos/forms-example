<?php

declare(strict_types=1);

namespace app\Application\Auth\Forms;

use app\Domain\Auth\LoginFormValidatorInterface;
use lib\FormValidator;
use Symfony\Component\Validator\Constraints as Assert;

class LoginFormValidator extends FormValidator implements LoginFormValidatorInterface
{
    public function getFormConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'username' => new Assert\Email([
                'message' => 'The email "{{ value }}" is not a valid email.', // Ways to add custom messages
            ]),
            'password' => new Assert\Length(['min' => 5])
        ]);
    }
}
