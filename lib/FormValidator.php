<?php
declare(strict_types=1);

namespace lib;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

class FormValidator implements FormValidatorInterface
{
    private CsrfManagerInterface $csrfManager;

    private array $errorList;

    public function __construct(CsrfManagerInterface $csrfManager)
    {
        $this->csrfManager = $csrfManager;
    }
    //implement it to take request value object here
    public function validateInput(FormRequest $formData): array
    {
        //should make this a bit more cleaner and inject this
        $validator = Validation::createValidator();

        foreach ($formData as $key => $value) {
            if ($key === '_token' || $key === 'submit') {
                unset ($formData[$key]);
            }
        }

        if(!$this->isCSRFTokenValid($formData)) {
            die('choose what you want to do for the csrf error, discuss best approach');
        }

        $errors = $validator->validate($formData->toArray(), $this->getFormConstraints(), $this->getGroupSequence());
        return $this->returnValidErrorMessageList($errors);
    }

    public function getFormConstraints(): Assert\Collection
    {
        return new Assert\Collection([]);
    }

    public function getGroupSequence(): Assert\GroupSequence
    {
        return new Assert\GroupSequence(['Default', 'custom']);
    }

    /**
     * @param ConstraintViolationListInterface $validationErrors
     * @return ConstraintViolationInterface[]
     */
    public function returnValidErrorMessageList(ConstraintViolationListInterface $validationErrors): array // The return can be typed into my own Error message object
    {
        $this->errorList = [];

        foreach ($validationErrors as $error) {
            if (!$error instanceof ConstraintViolationInterface) continue;
            $this->errorList[] =
                [
                    'message' => $error->getMessage()
                ];
        }
        return $this->errorList;
    }

    private function isCSRFTokenValid(FormRequest $formData): bool
    {
        if(!$this->csrfManager->isValidToken($formData->getFormName(), $formData->getToken())) {
            return false;
        }

        return true;
    }

}
