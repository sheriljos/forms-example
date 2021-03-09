<?php

declare(strict_types=1);

namespace app\Application\Logbook\Forms;

use lib\FormBuilderFactoryInterface;
use lib\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

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
            [
                'action' => '/logbooks/create'
            ]
        );

        return $builder
            ->add('name', TextType::class, [
                'label' => 'name',
                'translation_domain' => false,
                'constraints' => [
                    // Constraints would be the validation rules applied to the form
                    new NotBlank(),
                    new Assert\Length(['min' => 5])
                ]
            ])
            ->add('description', TextType::class, ['label' => 'description', 'translation_domain' => false ])
            ->add('submit', SubmitType::class, ['label' => 'Create', 'translation_domain' => false ] )
            ->getForm();
    }
}
