<?php

namespace App\Form;

use App\Entity\Wine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotNull;

class WineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $wine = $options['data'] ?? null;
        $isEdit = $wine && $wine->getId();

        $builder
            ->add('name')
            ->add('vintage')
            ->add('grape')
            ->add('country')
            ->add('region')
            ->add('description');

        $imageConstraints = [
            new Image([
                'maxSize' => '2M'
            ]),
        ];

        if (!$isEdit || !$wine->getImagePath()) {
            $imageConstraints[] = new NotNull([
                'message' => 'Please upload an image'
            ]);
        }

        $builder
            ->add('imageFile', FileType::class, [
                'attr' => ['class' => 'btn'],
                'mapped' => false,
                'required' => false,
                'constraints' => $imageConstraints,
            ])
            ->add('Update', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Wine::class,
        ]);
    }
}
