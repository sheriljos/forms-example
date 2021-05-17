<?php

declare(strict_types=1);

namespace lib\Fields;

use lib\OptionFieldInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class CheckboxInput implements OptionFieldInterface
{
    private string $name;
    private string $label;
    private array $options;
    private array $constraints;

    public function __construct(
        string $name,
        string $label,
        array $options,
        array $constraints = []
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->options = $options;
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

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getConstraints(): array
    {
        return $this->constraints;
    }

    public function getClassNames(): array
    {
        return ['checkbox'];
    }

    public function getType(): string
    {
        return CheckboxType::class;
    }
}
