<?php

namespace app\Application\Auth\Forms;

use Symfony\Component\Form\FormInterface;

interface LoginFormBuilderInterface
{
    public function buildForm(): FormInterface;
}
