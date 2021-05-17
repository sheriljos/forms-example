<?php

namespace lib;

interface OptionFieldInterface extends FieldInterface
{
    public function getOptions(): array;
}
