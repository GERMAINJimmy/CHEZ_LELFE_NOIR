<?php

namespace App\Form;

use App\Entity\Commentaire;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CommentaireFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('note')
            ->add('message', CKEditorType::class) // Ce champ sera remplacé par un éditeur WYSIWIG)
            ->add('rgpd', CheckboxType::class, [
                'label' => 'J\'accepte que mes informations soient stockées dans la base de données de Chez L\'elfe Noir pour la gestion des commentaires. J\'ai bien noté qu\'en aucun cas ces données ne seront cédées à des tiers.'])
            ->add('envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}
