<?php

namespace lib;

use Psr\Http\Message\ResponseInterface;

interface responseFactoryInterface
{
    public function html(string $html, int $status=200): ResponseInterface;
}
