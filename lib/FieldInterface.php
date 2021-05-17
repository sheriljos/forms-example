<?php

namespace lib;

interface FieldInterface
{
    public function getName(): string;

    public function getLabel(): string;

    public function getClassNames(): array;

    public function getConstraints(): array;

    public function getType(): string;
}
