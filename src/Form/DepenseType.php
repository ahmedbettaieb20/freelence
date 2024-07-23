<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Depense;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DepenseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('montant')
            ->add('date', DateTimeType::class, [
                'data' => new \DateTime(),
                'years' => range(date("Y"), date("Y") + 10),
                'widget' => 'single_text',
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Confirmé",
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Depense::class,
        ]);
    }
}
