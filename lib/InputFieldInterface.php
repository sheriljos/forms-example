<?php

namespace lib;

interface InputFieldInterface extends FieldInterface
{
    public function getPlaceholder(): string;
}
