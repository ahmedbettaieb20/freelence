<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prix')
            ->add('Qte')
            ->add('description')
            
            ->add('category', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom', // ou tout autre champ que vous souhaitez afficher
            ])
            ->add('image', FileType::class, [
                'label' => 'image',
                'mapped' => false, // Indique que ce champ n'est pas lié à une propriété de l'entité
                'required' => true, // Rend le champ facultatif pour les éditions
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
            'data_class' => Produit::class,
        ]);
    }
}
