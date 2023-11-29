<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Заголовок статьи',
                'attr' => [
                    'style' => 'width: 1000px; height: 30px',
                ]
            ])
            ->add('preview', TextType::class, [
                'attr' => [
                    'style' => 'width: 1000px; height: 30px',
                ]
            ])
            ->add('text', TextareaType::class, [
                'attr' => [
                    'style' => 'width: 1000px; height: 300px',
                ]
            ])
            ->add('image', FileType::class, [
                'data_class' => null,
//                'required' => false,
//                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
