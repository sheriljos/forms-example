# Symfony Forms in custom PHP app POC

This is a proof of concept. Here i am implementing symfony forms in a custom (non-symfony) native PHP project. I am trying to keep to clean architecture and keep everything as SOLID as possible. In this project i make use of simple routing, Dependency injection and some other familiar things you might see in the codebase. Please note there is not any logging in this application nor is there any connection to the DB, i print and die on a successful submit.

## Main Packages used
- league/route (For routing)
- league/container (DI Container)
- twig/twig
- symfony/form
- symfony/twig-bridge
- symfony/security-csrf
- symfony/translation
- twig/extensions
- symfony/psr-http-message-bridge
- symfony/validator
- doctrine/annotations

## Installation

```bash
    git clone [repo_url]
    composer install
    php -S 0.0.0.0:3000
```


## Usage

Create a request object that will be properties of the form, please be sure to extend all Request objects of the parent class FormRequest as below
```php
<?php

declare(strict_types=1);

namespace app\Domain\Logbook\Models;

use lib\FormRequest;

class Request extends FormRequest
{
    private string $name;

    private string $description;

    public function __construct(
        string $name,
        string $description,
        string $_token,
        string $formName
    ) {
        parent::__construct($formName, $_token);
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'description' => $this->getDescription()
        ];
    }
}
```

Once you have completed that please make an class for the validation rules that will be extended from the base FormValidation class, also be sure to create an interface for this new class to inject it to your container if you are using a DI container
```php

<?php

declare(strict_types=1);

namespace app\Application\Logbook\Forms;

use lib\FormValidator;
use app\Domain\Logbook\LogbookFormValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class LogbookFormValidator extends FormValidator implements LogbookFormValidatorInterface
{
    public function getFormConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'name' => new Assert\Length(['min' => 5]),
            'description' => new Assert\Length(['min' => 5])
        ]);
    }
}

```

Here comes the most important part, the Form Builder class!!! This is a simple example below where i create a form with a csrf token, and two fields named `name` and `description`

```php

<?php

declare(strict_types=1);

namespace app\Application\Logbook\Forms;

use lib\FormBuilderFactoryInterface;
use lib\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;

class CreateLogbookFormBuilder implements FormBuilderInterface
{
    private FormBuilderFactoryInterface $formBuilderFactory;

    public function __construct(FormBuilderFactoryInterface $formBuilderFactory)
    {
        $this->formBuilderFactory = $formBuilderFactory;
    }

    public function buildForm(): FormInterface
    {
        $formFactory = $this->formBuilderFactory->createFormBuilderFactory();
      
        $builder = $formFactory->createNamedBuilder(
            'logbook',
            FormType::class,
            [
                'csrf_protection' => true,
                'csrf_field_name' => '_token',
                'csrf_token_id' =>'logbook'
            ],
            ['action' => '/logbooks/create']
        );

        return $builder
            ->add('name', TextType::class, ['label' => 'name', 'translation_domain' => false]) // Added Constraints to this field to show validator in action
            ->add('description', TextType::class, ['label' => 'description', 'translation_domain' => false ])
            ->add('submit', SubmitType::class, ['label' => 'Create', 'translation_domain' => false ] )
            ->getForm();
    }
}

```

Here is the final step where i tie it all together, this is where i inject the formbuilder and the validator etc to my controller, this is where i will render and handler my form, please see below example

```php
<?php

declare(strict_types=1);

namespace app\Application\Logbook\Controller;

use app\Domain\Logbook\LogbookFormValidatorInterface;
use app\Domain\Logbook\Models\Request;
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
```

