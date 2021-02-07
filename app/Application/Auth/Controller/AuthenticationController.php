<?php

declare(strict_types=1);

namespace app\Application\Auth\Controller;

use app\Application\Auth\Forms\LoginFormBuilderInterface;
use app\Application\Logbook\Forms\LogbookFormValidator;
use app\Domain\Auth\LoginFormValidatorInterface;
use app\Domain\Auth\Models\Request;
use lib\CsrfManagerInterface;
use lib\responseFactoryInterface;
use lib\TemplateInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthenticationController
{
    /**
     * @var TemplateInterface
     */
    private TemplateInterface $templateEngine;

    /**
     * @var responseFactoryInterface
     */
    private responseFactoryInterface $responseFactory;

    /**
     * @var LoginFormBuilderInterface
     */
    private LoginFormBuilderInterface $formBuilder;

    /**
     * @var CsrfManagerInterface
     */
    private CsrfManagerInterface $csrfManager;

    /**
     * @var LoginFormValidatorInterface
     */
    private LoginFormValidatorInterface $loginFormValidator;

    public function __construct
    (
        TemplateInterface $templateEngine,
        responseFactoryInterface $responseFactory,
        LoginFormBuilderInterface $formBuilder,
        LoginFormValidatorInterface $loginFormValidator
    ) {
        $this->templateEngine = $templateEngine;
        $this->responseFactory = $responseFactory;
        $this->formBuilder = $formBuilder;
        $this->loginFormValidator = $loginFormValidator;
    }


    public function login(ServerRequestInterface $request): ResponseInterface
    {
        $form =  $this->formBuilder->buildForm();
        $errorList = [];

        if ($request->getMethod() === "POST") {
            $formName = $form->getName();

            $post = $request->getParsedBody()[$formName];

            $submittedToken = $post['_token'];

            $request = new Request($post['username'], $post['password'], $submittedToken, $formName);

            $form->submit($post);
            $errorList = $this->loginFormValidator->validateInput($request);
            $isValid = (empty($errorList) ? true : false);
            if ($form->isSubmitted() && $isValid) {
                die('form is valid..now we can do what we want to');
            }
        }

        return $this->responseFactory->html($this->templateEngine->render(
            'Auth/login.twig',
            [
                'name' => 'neil',
                'form' => $form->createView(),
                'errors' => $errorList
            ]
        ));
    }

}
