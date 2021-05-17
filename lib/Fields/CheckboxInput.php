<?php

declare(strict_types=1);

namespace lib\Fields;

use lib\FieldInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class CheckboxInput implements FieldInterface
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $label;

    /**
     * @var string
     */
    private string $placeholder;

    /**
     * @var array
     */
    private array $classNames;

    /**
     * @var string
     */
    private string $type;

    /**
     * @var array
     */
    private array $constraints;

    /**
     * @var array
     */
    private array $options;

    public function __construct(
        string $name,
        string $label,
        array $constraints,
        array $options,
        string $type = CheckboxType::class,
        string $placeholder = "Please enter input here",
        array $classNames = ['checkbox']
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->classNames = $classNames;
        $this->constraints = $constraints;
        $this->options = $options;
        $this->type = $type;
        $this->placeholder = $placeholder;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getPlaceholder(): string
    {
        return $this->placeholder;
    }

    public function getClassNames(): array
    {
        return $this->classNames;
    }

    public function getConstraints(): array
    {
        return $this->constraints;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
