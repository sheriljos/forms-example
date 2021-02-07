<?php

namespace lib;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Constraints as Assert;

interface FormValidatorInterface
{
    public function validateInput(FormRequest $formData): array;

    public function getFormConstraints(): Assert\Collection;

    public function getGroupSequence(): Assert\GroupSequence;

    public function returnValidErrorMessageList(ConstraintViolationListInterface $validationErrors): array;

}
