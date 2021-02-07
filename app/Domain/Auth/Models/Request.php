<?php

declare(strict_types=1);

namespace app\Domain\Auth\Models;

use lib\FormRequest;

class Request extends FormRequest
{
    private string $username;

    private string $password;

    public function __construct(
        string $username,
        string $password,
        string $_token,
        string $formName
    ) {
        parent::__construct($formName, $_token);
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function toArray(): array
    {
        return [
            'username' => $this->getUsername(),
            'password' => $this->getPassword()
        ];
    }
}
