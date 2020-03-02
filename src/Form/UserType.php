<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['data'] ?? null;
        $isEdit = $user && $user->getId();

        $builder
            ->add('username')
            ->add('roles', ChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'choices' => [
                    'User' => "ROLE_USER",
                    'Admin' => "ROLE_ADMIN",
                ],
            ])
            ->add('password')
            ->add('firstname')
            ->add('lastname')
        ;

        $required = false;
        if (!$isEdit || !$user->getPassword()) {
            $required = true;
        }

        $builder
            ->add('password', TextType::class, [
                'required' => $required,
                'empty_data' => '',
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
