<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotNull;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $article = $options['data'] ?? null;
        $isEdit = $article && $article->getId();

        $builder
            ->add('title')
            ->add('text')
            ->add('imageFile')
        ;

        $imageConstraints = [
            new Image([
                'maxSize' => '2M'
            ]),
        ];

        if (!$isEdit || !$article->getImagePath()) {
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
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
