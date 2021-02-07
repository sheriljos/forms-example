<?php

declare(strict_types=1);

namespace app\Application\Auth\Forms;

use lib\FormBuilderFactoryInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;

class LoginFormBuilder implements LoginFormBuilderInterface
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
        $builder = $formFactory->createNamedBuilder('login',FormType::class,['csrf_protection' => true, 'csrf_field_name' => '_token', 'csrf_token_id' =>'login'],['action' => '/login']);

        return $builder
            ->add('username', TextType::class, ['label' => 'username', 'translation_domain' => false]) // Added Constraints to this field to show validator in action
            ->add('password', PasswordType::class, ['label' => 'password', 'translation_domain' => false ])
            ->add('submit', SubmitType::class, ['label' => 'Create', 'translation_domain' => false ] )
            ->getForm();
    }
}
