<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Inscrire;
use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class InscrireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('stagiaire', EntityType::class, [
                'class' => Stagiaire::class,
                'choice_label' => function (Stagiaire $stagiaire) {
                    return sprintf('%s %s', $stagiaire->getNom(), $stagiaire->getPrenom());
                },
                'placeholder' => 'Choisir un stagiaire',
            ]);


        $builder->add('save', SubmitType::class, [
            'label' => 'Inscrire Stagiaire'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscrire::class,
        ]);
    }
}
