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

        // $builder->get('roles')
        //     ->addModelTransformer(new CallbackTransformer(
        //         function ($rolesAsArray) {
        //             // transform the array to a string
        //             return json_encode($rolesAsArray, true);
        //         },
        //         function ($rolesAsJson) {
        //             // transform the string back to an array
        //             return json_decode($rolesAsJson);
        //         }
        //     ));

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
