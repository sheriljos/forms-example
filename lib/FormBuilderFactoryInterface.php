<?php

namespace lib;

use Symfony\Component\Form\FormFactoryInterface;

interface FormBuilderFactoryInterface
{
    /**
     * @return FormFactoryInterface
     */
    public function createFormBuilderFactory(): FormFactoryInterface;
}
