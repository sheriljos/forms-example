<?php

namespace lib;

use Symfony\Component\Form\FormInterface;

interface FormBuilderInterface
{
    public function buildForm(): FormInterface;
}
