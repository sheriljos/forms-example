<?php
declare(strict_types=1);

namespace app\Application\Logbook\Controller;

use config\presentation\TemplateInterface;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LogbookController
{
    /**
     * @var TemplateInterface
     */
    private TemplateInterface $templateEngine;

    public function __construct(TemplateInterface $templateEngine)
    {
        $this->templateEngine = $templateEngine;
    }

    public function get(ServerRequestInterface $request): ResponseInterface
    {
        return new Response\HtmlResponse($this->templateEngine->render(
            'Logbook/index.twig',
            [
                'name' => 'neil'
            ]
        ));
    }
}
