<?php
declare(strict_types=1);

namespace app\Application\Dashboard\Controller;

use config\presentation\TemplateInterface;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response;

class dashboardController
{
    /**
     * @var TemplateInterface
     */
    private TemplateInterface $templateEngine;

    public function __construct(TemplateInterface $templateEngine)
    {
        $this->templateEngine = $templateEngine;
    }

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        return new Response\HtmlResponse($this->templateEngine->render(
            'test.twig',['message' => 'neil']
        ));
    }

}
