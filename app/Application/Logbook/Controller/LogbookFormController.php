<?php

declare(strict_types=1);

namespace app\Application\Logbook\Controller;

use lib\Fields\CheckboxInput;
use lib\Fields\RadioButtonInput;
use lib\Fields\TextAreaInput;
use lib\Fields\TextInput;
use lib\FormBuilderFactoryInterface;
use lib\responseFactoryInterface;
use lib\TemplateInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
// Last bit of symfony to get rid of, i will create my own custom rules extended from the assert base that we can use our own classes and then
// if we do not use symfony anymore we do not have to change it in every controller
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;

class LogbookFormController
{
    private TemplateInterface $templateEngine;
    private responseFactoryInterface $responseFactory;
    private FormBuilderFactoryInterface $formBuilder;
    private FormInterface $form;

    public function __construct
    (
        TemplateInterface $templateEngine,
        responseFactoryInterface $responseFactory,
        FormBuilderFactoryInterface $formBuilder
    ) {
        $this->templateEngine = $templateEngine;
        $this->responseFactory = $responseFactory;
        $this->formBuilder = $formBuilder;
        $this->form = $this->initializeForm(); // Abstracted to priv function as this i did not want to do in constructor || Can also be abstracted to an separate class and be re-usable in a sense
    }

    public function get(ServerRequestInterface $request): ResponseInterface
    {
        return  $this->responseFactory->html($this->templateEngine->render(
            'Logbook/form.twig',
            [
                'form' =>  $this->form->createView(),
                'errors' => []
            ]
        ));
    }

    public function post(ServerRequestInterface $request): ResponseInterface
    {

        // Get Post Data
        $formData = $request->getParsedBody()[$this->form->getName()];
        //Submit form to backend component to see if any attached validation errors are returned from the system
        $this->form->submit($formData);

        //Form is valid, do what you please
        if ($this->form->isValid() && $this->form->isSubmitted()) {
            echo "<pre>";
            print_r($request->getParsedBody());
            die('validFormData');
        }

        //Form was not valid
        return  $this->responseFactory->html($this->templateEngine->render(
            'Logbook/form.twig',
            [
                'form' =>  $this->form->createView(),
                'errors' => $this->form->getErrors(true)
            ]
        ));
    }

    private function initializeForm(): FormInterface
    {
        return $this->form = $this->formBuilder->create(
            'formDemo',
            '/logbooks/create',
            'token',
            new TextInput(
                'name',
                'Name',
                [
                    new Length(['min' => 6]),
                    new Assert\NotBlank()
                ]
            ),
            new TextInput(
                'description',
                'Description',
                [
                    new Length(['min' => 5]),
                    new Assert\NotBlank()
                ]
            ),
            new TextAreaInput(
                'TextArea',
                'textarea'
            ),
            new CheckboxInput(
                'Checkbox',
                'checkbox',
                ['test1','test2']
            ),
            new RadioButtonInput(
                'RadioButton',
                'radioButton',
                ['test1','test2']
            ),
        );
    }
}
