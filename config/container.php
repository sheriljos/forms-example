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
    ->addArgument(lib\FormBuilderInterface::class)
    ->addArgument(app\Domain\Logbook\LogbookFormValidatorInterface::class);

$container->add(app\Application\Auth\Controller\AuthenticationController::class)
    ->addArgument(lib\TemplateInterface::class)
    ->addArgument(lib\responseFactoryInterface::class)
    ->addArgument(app\Application\Auth\Forms\LoginFormBuilderInterface::class)
    ->addArgument(app\Domain\Auth\LoginFormValidatorInterface::class);

/**
 * GENERAL
 */
$container->add(lib\FormValidatorInterface::class, lib\FormValidator::class )
    ->addArgument(lib\CsrfManagerInterface::class);

$container->add(lib\FormBuilderInterface::class, app\Application\Logbook\Forms\CreateLogbookFormBuilder::class )
    ->addArgument(lib\FormBuilderFactoryInterface::class);

$container->add(app\Application\Auth\Forms\LoginFormBuilderInterface::class, app\Application\Auth\Forms\LoginFormBuilder::class )
    ->addArgument(lib\FormBuilderFactoryInterface::class);

$container->add(lib\FormBuilderFactoryInterface::class, lib\FormFactoryBuilder::class );
$container->add(lib\CsrfManagerInterface::class, lib\CsrfManager::class );
$container->add(lib\TemplateInterface::class, lib\TemplateEngine::class );
$container->add(lib\responseFactoryInterface::class, lib\responseFactory::class );

/**
 * VALIDATORS
 */

$container->add(app\Domain\Logbook\LogbookFormValidatorInterface::class, app\Application\Logbook\Forms\LogbookFormValidator::class)
    ->addArgument(lib\CsrfManagerInterface::class); // Why do i have to inject it here as well??? is it because i am extending a class where it is injected ?

$container->add(app\Domain\Auth\LoginFormValidatorInterface::class, app\Application\Auth\Forms\LoginFormValidator::class)
    ->addArgument(lib\CsrfManagerInterface::class); //

$strategy = new League\Route\Strategy\JsonStrategy(new ResponseFactory());
$strategy->setContainer($container);

