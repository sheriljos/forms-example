<?php

declare(strict_types=1);

namespace lib;

class FormRequest
{
    private string $formName;

    private string $_token;

    public function __construct(string $formName, string $_token)
    {
        $this->formName = $formName;
        $this->_token = $_token;
    }

    /**
     * @return string
     */
    public function getFormName(): string
    {
        return $this->formName;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->_token;
    }
}
