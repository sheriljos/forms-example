<?php

declare(strict_types=1);

namespace app\Application\Logbook\Controller;

use app\Application\Logbook\Forms\LogbookFormValidator;
use app\Domain\Logbook\LogbookFormValidatorInterface;
use app\Domain\Logbook\Models\Request;
use lib\CsrfManagerInterface;
use lib\FormBuilderInterface;
use lib\responseFactoryInterface;
use lib\TemplateInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LogbookFormController
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
     * @var FormBuilderInterface
     */
    private FormBuilderInterface $formBuilder;

    /**
     * @var LogbookFormValidatorInterface
     */
    private LogbookFormValidatorInterface $formValidator;

    public function __construct
    (
        TemplateInterface $templateEngine,
        responseFactoryInterface $responseFactory,
        FormBuilderInterface $formBuilder,
        LogbookFormValidatorInterface $formValidator
    ) {
        $this->templateEngine = $templateEngine;
        $this->responseFactory = $responseFactory;
        $this->formBuilder = $formBuilder;
        $this->formValidator = $formValidator;
    }

    public function create(ServerRequestInterface $request): ResponseInterface
    {
        $form =  $this->formBuilder->buildForm();
        $errorList = [];

        if ($request->getMethod() === "POST") {
            $formName = $form->getName();
            // Try and seperate this for the Request object
            $post = $request->getParsedBody()[$formName];

            $submittedToken = $post['_token'];

            $request = new Request($post['name'], $post['description'], $submittedToken, $formName);

            $form->submit($post); // Should this be removed or not, what benefits do we get from this ? Seeing as i have the LogbookRequest

            $errorList = $this->formValidator->validateInput($request); // Need to look into doing the validator better, because what i am currently doing is ... yeah
            $isValid = (empty($errorList) ? true : false);
            if ($form->isSubmitted() && $isValid) {
                echo "<pre>"; print_r($request);
                die('form is valid..now we can do what we want to');
            }
        }

        return $this->responseFactory->html($this->templateEngine->render(
            'Logbook/form.twig',
            [
                'form' => $form->createView(),
                'errors' => $errorList
            ]
        ));
    }
}
