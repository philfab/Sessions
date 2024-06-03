<?php

// src/Form/ProgrammeType.php

namespace App\Form;

use App\Entity\Module;
use App\Entity\Programme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProgrammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('module', EntityType::class, [
                'class' => Module::class,
                'choices' => $options['modules_non_programmes'],
                'choice_label' => 'titre',
                'label' => 'Module',
            ])
            ->add('nbJours', IntegerType::class, [
                'label' => 'Nombre de jours',
                'required' => true,
                'attr' => [
                    'min' => 1,
                    'value' => 1
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Ajouter Programme',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Programme::class,
            'modules_non_programmes' => [],
        ]);
    }
}
