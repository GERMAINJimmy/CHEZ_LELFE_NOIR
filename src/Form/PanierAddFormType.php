<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PanierAddFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $tabChoices = array(1,2,3,4,5);
        $tabChoices = array();
        for($i=1; $i<=$options['nbExemplaires'] && $i<=5; $i++)
        {
            $tabChoices[$i]=$i;
        }
        
        $builder
            -> add('nbExemplaires', ChoiceType::class, array(
                'choices' => $tabChoices
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            'nbExemplaires' => 5
        ]);
    }
}
