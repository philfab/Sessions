<?php

namespace App\Form;

use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StagiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'datepicker'],
                'label' => 'Date de naissance',
                'required' => true,
            ])
            ->add('sexe', ChoiceType::class, [
                'choices' => [
                    'M' => true,
                    'F' => false,
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => true,
                'label' => 'Sexe',
            ])
            ->add('email', EmailType::class)
            ->add('ville', TextType::class)
            ->add('telephone', TextType::class)
            ->add('save', SubmitType::class, [
                'label' => 'Créer Stagiaire',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
        ]);
    }
}
