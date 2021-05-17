<?php

declare(strict_types=1);

namespace lib;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Csrf\CsrfExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Forms;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Security\Csrf\TokenGenerator\UriSafeTokenGenerator;
use Symfony\Component\Security\Csrf\TokenStorage\NativeSessionTokenStorage;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FormBuilderFactory implements FormBuilderFactoryInterface
{
    private UriSafeTokenGenerator $csrfGenerator;

    private CsrfTokenManager $csrfManager;

    private NativeSessionTokenStorage $csrfStorage;

    private ValidatorInterface $validator;

    public function __construct()
    {
        $this->csrfGenerator = new UriSafeTokenGenerator();
        $this->csrfStorage = new NativeSessionTokenStorage();
        $this->csrfManager = new CsrfTokenManager($this->csrfGenerator, $this->csrfStorage);
        $this->validator = Validation::createValidator();
    }

    /**
     * @param string $name
     * @param string $formAction
     * @param string $csrfTokenName
     * @param FieldInterface ...$fields
     * @return FormInterface
     */
    public function create(string $name, string $formAction, string $csrfTokenName, FieldInterface ...$fields): \Symfony\Component\Form\FormInterface  // Please note this will interfaced by our own interface
    {

        $builder = Forms::createFormFactoryBuilder()
            ->addExtension(new CsrfExtension($this->csrfManager))
            ->addExtension(new ValidatorExtension($this->validator))
            ->getFormFactory();

        $builder = $builder->createNamedBuilder(
            $name,
            FormType::class,
            [
                'csrf_protection' => true, // By default this will always be true
                'csrf_field_name' => $csrfTokenName,
                'csrf_token_id' => $csrfTokenName
            ],
            [
                'action' => $formAction
            ]
        );

        foreach ($fields as $formField) {
            switch ($formField->getType()) {
                case CheckboxType::class:
                    $builder->add(
                        $formField->getName(),
                        ChoiceType::class,
                        [
                            'label' => $formField->getLabel(),
                            'translation_domain' => false,
                            'constraints' => $formField->getConstraints(),
                            'attr' => ['class' => implode(' ', $formField->getClassNames())],
                            'choices' => $formField->getOptions(),
                            'multiple' => true,
                            'expanded' => true,
                        ],
                    );
                    break;
                case RadioType::class:
                    $builder->add(
                        $formField->getName(),
                        ChoiceType::class,
                        [
                            'label' => $formField->getLabel(),
                            'translation_domain' => false,
                            'constraints' => $formField->getConstraints(),
                            'attr' => ['class' => implode(' ', $formField->getClassNames())],
                            'choices' => $formField->getOptions(),
                            'multiple' => false,
                            'expanded' => true,
                        ],
                    );
                    break;
                case TextType::class:
                case TextareaType::class:
                    $builder->add(
                        $formField->getName(),
                        $formField->getType(),
                        [
                            'label' => $formField->getLabel(),
                            'translation_domain' => false,
                            'constraints' => $formField->getConstraints(),
                            'attr' => ['class' => implode(' ', $formField->getClassNames())]
                        ],
                    );
                    break;
            }
        }

        // We will create a type for this, this is for now just to add a submit for now
        $builder->add(
            'submit',
            SubmitType::class,
            [
                'label' => 'Submit',
                'translation_domain' => false,
                'attr' => ['class' => 'button btn-primary']
            ]
        );

        return $builder->getForm();
    }
}
