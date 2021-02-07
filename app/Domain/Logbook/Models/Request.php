<?php

declare(strict_types=1);

namespace app\Domain\Logbook\Models;

use lib\FormRequest;

class Request extends FormRequest
{
    private string $name;

    private string $description;

    public function __construct(
        string $name,
        string $description,
        string $_token,
        string $formName
    ) {
        parent::__construct($formName, $_token);
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'description' => $this->getDescription()
        ];
    }
}
