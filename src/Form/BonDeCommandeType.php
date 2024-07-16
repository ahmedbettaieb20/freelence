<?php

namespace App\Form;

use App\Entity\BonDeCommande;
use App\Entity\Produit;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BonDeCommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date',DateTimeType::class, [
                'data' => new \DateTime(),
                'years' => range(date("Y"), date("Y") + 10),
                'widget' => 'single_text',
            ])
            ->add('montant')
            ->add('quantite')
            ->add('nomComercial', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'FirstName', // ou tout autre champ que vous souhaitez afficher
            ])
            ->add('statut')
            ->add('produit', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => 'nom', // ou tout autre champ que vous souhaitez afficher
            ])
           
                ->add('submit',SubmitType::class,[
                    'label'=>"confirmer",
                ])  
            ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BonDeCommande::class,
        ]);
    }
}
