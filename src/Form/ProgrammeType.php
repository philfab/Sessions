<?php

// src/Form/ProgrammeType.php

namespace App\Form;

use App\Entity\Programme;
use App\Entity\Module;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProgrammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('module', EntityType::class, [
                'class' => Module::class,
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Programme::class,
        ]);
    }
}
