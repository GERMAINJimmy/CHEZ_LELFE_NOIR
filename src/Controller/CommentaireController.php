<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentaire/add", name="commentaire_add")
     * @Route("/commentaire/{id}/edit", name="commentaire_edit")
     */
        // On demande a Symfony de nous passer un commentaire qui peut etre null, puis ce preparer a receptionner une requete et la soumettre avec le manager
        public function Commentaire(Commentaire $commentaire = null, Request $request, EntityManagerInterface $manager)
        {
            // si le commentaire n'existe pas, on initialise un nouveau commentaire, sinon le formulaire sera hydrater par le commentaire
            if(!$commentaire){
                $commentaire = new Commentaire();
            }
            // creation du formulaire
            $form = $this->createForm(CommentaireFormType::class, $commentaire);
            // traiter les info du formulaire
            $form->handleRequest($request);
            // si le formulaire est soumis et valide
            if($form->isSubmitted() && $form->isValid()){
                // si le commentaire n'existe pas initalise la date d'enregistrement
                if(!$commentaire->getId()){
                    $commentaire->setDateEnregistrement(new \DateTime());
                }
                // le manager se prepare a enregistrer l'article
                $manager->persist($commentaire);
                // le manager envoie la requete à la base
                $manager->flush();
                // redirection automatique 
                return $this->redirectToRoute('commentaire/index.html.twig',[
                    // on envoi l'id du commentaire
                    'id' => $commentaire->getId()
                ]);
            }
            
            return $this->render('commentaire/commentaire_form.html.twig',[
                'formCommentaire' => $form->createView(),
                'editMode' => $commentaire->getId() !== null,
            ]);
        }
}
