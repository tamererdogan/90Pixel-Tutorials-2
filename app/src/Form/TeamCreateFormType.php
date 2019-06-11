<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class TeamCreateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('teamName', TextType::class,  [
            'label' => ' ',
            'attr' => ['class' => 'form-control w-100', 'placeholder' => 'Takım Adı Giriniz'],
        ])
            ->add('teamSubmit', SubmitType::class, [
            'label' => 'Takım Ekle',
            'attr' => ['class' => 'btn btn-primary w-100'],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
