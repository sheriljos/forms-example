<?php

declare(strict_types=1);

namespace Application\Logbook\Controller;

use app\Application\Logbook\Controller\LogbookController;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\StreamFactory;
use lib\TemplateInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use lib\ResponseFactoryInterface;
use Prophecy\Prophet;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;

class LogbookControllerTest extends TestCase
{

    private LogbookController $logbookController;

    private TemplateInterface $templateEngine;

    private ResponseFactoryInterface $responseFactoryInterface;

    private Prophet $prophet;

    public function setup(): void
    {
        $this->prophet = new Prophet();
        $this->templateEngine = $this->prophet->prophesize(TemplateInterface::class);
        $this->responseFactoryInterface = $this->prophet->prophesize(ResponseFactoryInterface::class);
        $this->logbookController = new LogbookController($this->templateEngine->reveal(), $this->responseFactoryInterface->reveal());
    }

    public function testGetFunctionProperlyResponds(): void
    {
        $self = $this;
        $this->templateEngine->render('Logbook/index.twig', Argument::any())
            ->willReturn('logbook page');

        $this->responseFactoryInterface->html(Argument::any(), Argument::any())
            ->will(function (array $args) use ($self): ResponseInterface {
                $stream = $self->createStream($args[0]);

                return $self->createResponse()->withBody($stream);
            });

        $response = $this->logbookController->get($this->createServerRequest('get', '/logbooks'));

        $this->assertEquals(200,$response->getStatusCode());
        $this->assertEquals('logbook page',$response->getBody()->getContents());
    }

    public function createServerRequest(string $method, string $uri, array $serverParams = []): ServerRequestInterface
    {
        return (new ServerRequestFactory())->createServerRequest($method, $uri, $serverParams);
    }

    public function createStream(string $stream): StreamInterface
    {
        return (new StreamFactory())->createStream($stream);
    }

    public function createResponse(int $code = 200): ResponseInterface
    {
        return (new ResponseFactory())->createResponse($code);
    }

}
