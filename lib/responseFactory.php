<?php
declare(strict_types=1);

namespace lib;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;

class responseFactory implements responseFactoryInterface
{

    public function html(string $html, int $status=200): ResponseInterface
    {
        return new HtmlResponse($html, $status);
    }
}
