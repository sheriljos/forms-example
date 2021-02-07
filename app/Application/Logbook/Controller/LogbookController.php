<?php
declare(strict_types=1);

namespace app\Application\Logbook\Controller;

use lib\FormBuilderInterface;
use lib\responseFactoryInterface;
use lib\TemplateInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LogbookController
{
    /**
     * @var TemplateInterface
     */
    private TemplateInterface $templateEngine;

    /**
     * @var responseFactoryInterface
     */
    private responseFactoryInterface $responseFactory;

    public function __construct(TemplateInterface $templateEngine, responseFactoryInterface $responseFactory)
    {
        $this->templateEngine = $templateEngine;
        $this->responseFactory = $responseFactory;
    }

    public function get(ServerRequestInterface $request): ResponseInterface
    {
        return $this->responseFactory->html($this->templateEngine->render(
            'Logbook/index.twig',
            [
                'name' => 'Logbooks'
            ]
        ));
    }
}
