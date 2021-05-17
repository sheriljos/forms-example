<?php

declare(strict_types=1);

namespace app\Application\Logbook\Controller;

use lib\FormBuilderInterface;
use lib\responseFactoryInterface;
use lib\TemplateInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

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


    public function __construct
    (
        TemplateInterface $templateEngine,
        responseFactoryInterface $responseFactory,
        FormBuilderInterface $formBuilder
    ) {
        $this->templateEngine = $templateEngine;
        $this->responseFactory = $responseFactory;
        $this->formBuilder = $formBuilder;
    }

    public function create(ServerRequestInterface $request): ResponseInterface
    {
        $form =  $this->formBuilder->buildForm();

        if ($request->getMethod() === "POST") {

            $post = $request->getParsedBody()[$form->getName()];
            $form->submit($post);
            $errorList = $form->getErrors(true);

            if ($form->isValid() && $form->isSubmitted()) {
                //Here we are done and know we have a valid form
                echo "<pre>"; print_r($form->getData());
                die('form is valid..now we can do what we want to');
            }
            //Form is not valid and will return with a list of errors
            return $this->responseFactory->html($this->formatResponseTemplate($form, $errorList));
        }
        // Simply just render on a get
        return $this->responseFactory->html($this->formatResponseTemplate($form));
    }

    private function formatResponseTemplate(FormInterface $form, FormErrorIterator $formErrors=null): string
    {
        return $this->templateEngine->render(
            'Logbook/form.twig',
            [
                'form' => $form->createView(),
                'errors' => $formErrors
            ]
        );
    }
}
