<?php

namespace App\Form;

use App\Entity\Commentaire;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert; 

class CommentaireFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('note', IntegerType::class, array(
                'label' => 'note*',
                'required' => false,     // non utile dans notre exemple car en amont on a défini un novalidation pour tous les champs (cf fonction configureOptions(), après cette buildform)
                'constraints' => array(
                    // le champ ne doit pas être null
                    new Assert\NotBlank(array(
                        'message' => 'Veuillez remplir ce champ'       /* celui par défaut est en anglais */
                    )),
                    // Gestion des longueurs de champs
                    new Assert\Length(array(
                        'min' => 0,
                        'max' => 5,
                        'minMessage' => 'La note ne peut pas être inférieur à {{ limit }}',
                        'maxMessage' => 'La note ne peut pas être supérieur à {{ limit }}'
                    )),
                )
            ))
            ->add('message', CKEditorType::class, array( // Ce champ sera remplacé par un éditeur WYSIWIG)
                'label' => 'Message*',
                'required' => false,     // non utile dans notre exemple car en amont on a défini un novalidation pour tous les champs (cf fonction configureOptions(), après cette buildform)
                'constraints' => array(
                    // le champ ne doit pas être null
                    new Assert\NotBlank(array(
                        'message' => 'Veuillez remplir ce champ'       /* celui par défaut est en anglais */
                    )),
                    // Gestion des longueurs de champs
                    new Assert\Length(array(
                        'min' => 8,
                        'minMessage' => 'Veuillez renseigner au moins {{ limit }} caractères'
                    )),
                )
            )) 
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
