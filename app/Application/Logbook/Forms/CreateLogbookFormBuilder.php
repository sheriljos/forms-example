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
        /**
         * PLEASE NOTE I WILL BE INJECTING A BUILDER !!!!! THIS IS A POC
         * This is to show i can return an instance of the builder interface and use it in my builders...i will play around with this concept
         * The line below is a form with a csrf token built. We need to see how we are going to handle this
         * $builder = $formFactory->createNamedBuilder('logbook',FormType::class,['csrf_protection' => true, 'csrf_field_name' => '_token', 'csrf_token_id' =>'logbooks'],['action' => '/logbooks/create']);
         *
         **/
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
