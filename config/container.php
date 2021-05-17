<?php

declare(strict_types=1);

use Laminas\Diactoros\ResponseFactory;

$container = new League\Container\Container;

/**
 * CONTROLLERS
 */
$container->add(app\Application\Dashboard\Controller\DashboardController::class)
    ->addArgument(lib\TemplateInterface::class);

$container->add(app\Application\Logbook\Controller\LogbookController::class)
    ->addArgument(lib\TemplateInterface::class)
    ->addArgument(lib\responseFactoryInterface::class);

$container->add(app\Application\Logbook\Controller\LogbookFormController::class)
    ->addArgument(lib\TemplateInterface::class)
    ->addArgument(lib\responseFactoryInterface::class)
    ->addArgument(lib\FormBuilderFactoryInterface::class);

$container->add(lib\FormBuilderFactoryInterface::class, lib\FormBuilderFactory::class );
$container->add(lib\TemplateInterface::class, lib\TemplateEngine::class );
$container->add(lib\responseFactoryInterface::class, lib\responseFactory::class );

$strategy = new League\Route\Strategy\JsonStrategy(new ResponseFactory());
$strategy->setContainer($container);

