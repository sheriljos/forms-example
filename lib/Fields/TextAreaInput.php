<?php

declare(strict_types=1);

namespace lib\Fields;

use lib\InputFieldInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TextAreaInput implements InputFieldInterface
{
    private string $name;
    private string $label;
    private string $placeholder;
    private array $constraints;

    public function __construct(
        string $name,
        string $label,
        array $constraints = [],
        string $placeholder = "Please enter input here"
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->constraints = $constraints;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getConstraints(): array
    {
        return $this->constraints;
    }

    public function getPlaceholder(): string
    {
        return $this->placeholder;
    }

    public function getClassNames(): array
    {
        return ['input'];
    }

    public function getType(): string
    {
        return TextareaType::class;
    }
}
