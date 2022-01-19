<?php

namespace App\Form;

use App\Entity\Heberge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HebergeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numcli')
            ->add('numchambre')
            ->add('dateentre')
            ->add('nbjours')
            ->add('montant')
            ->add('compagne')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Heberge::class,
        ]);
    }
}
