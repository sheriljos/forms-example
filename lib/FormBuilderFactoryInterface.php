<?php

namespace lib;

use Symfony\Component\Form\FormInterface;

interface FormBuilderFactoryInterface
{
    /**
     * @param string $name
     * @param string $formAction
     * @param string $csrfTokenName
     * @param FieldInterface ...$fields
     * @return FormInterface
     */
    public function create(string $name, string $formAction, string $csrfTokenName, FieldInterface ...$fields): FormInterface;
}
