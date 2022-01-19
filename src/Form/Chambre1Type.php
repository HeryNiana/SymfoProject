<?php

namespace App\Form;

use App\Entity\Chambre;
use App\Entity\Categorie1;
use App\Entity\FemmeChambre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
//use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class Chambre1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codech', TextType::class,[
                'label'=>false,
                'attr'=>[
                    'autocomplete'=>'off'
                ]
                ])
            ->add('prixjournalier',NumberType::class,[
                'label'=>false,
                'attr'=>[
                    'autocomplete'=>'off'
                ]
                ])
            ->add('photo', FileType::class,[
                'label'=>false,
                'multiple'=>true,
                'mapped'=>false,
                'required'=>true
            ])
            ->add('capacite',TextType::class,[
                'label'=>false,
                'attr'=>[
                    'autocomplete'=>'off'
                ]
                ])
            ->add('categorie1id',EntityType::class, [
                'class' => Categorie1::class,
                'choice_label' => 'type',
                'label'=>false
            ])
            ->add('femmeid',EntityType::class, [
                'class' => FemmeChambre::class,
                'choice_label' => 'nom',
                'label'=>false
            ])
            /*->add('heuremenage',TimeType::class, [
                'label'=>false,
                'required'=>true
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Chambre::class,
        ]);
    }
}
