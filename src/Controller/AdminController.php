<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitFormType;
use App\Entity\Atelier;
use App\Form\AtelierFormType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/produit", name="admin_produit")
     */
    public function produitIndex()
    {
        return $this->render('admin/produit_index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @Route("/admin/atelier", name="admin_atelier")
     */
    public function atelierIndex()
    {
        return $this->render('admin/atelier_index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @Route("/admin/produit/add", name="admin_produit_add")
     * @Route("/admin/produit/{id}/edit", name="admin_produit_edit")
     */
        // On demande a Symfony de nous passer un produit qui peut etre null, puis ce preparer a receptionner une requete et la soumettre avec le manager
    public function adminProduit(Produit $produit = null, Request $request, EntityManagerInterface $manager)
    {
        // si le produit n'existe pas, on initialise un nouveau produit, sinon le formulaire sera hydrater par le produit
        if(!$produit){
            $produit = new Produit();
        }
        // creation du formulaire
        $form = $this->createForm(ProduitFormType::class, $produit);
        // traiter les info du formulaire
        $form->handleRequest($request);
        // si le formulaire est soumis et valide
        if($form->isSubmitted() && $form->isValid()){
            // si le produit n'existe pas initalise la date d'enregistrement
            if(!$produit->getId()){
                $produit->setDateEnregistrement(new \DateTime());
            }
            // le manager se prepare a enregistrer l'article
            $manager->persist($produit);
            // le manager envoie la requete à la base
            $manager->flush();
            // redirection automatique 
            return $this->redirectToRoute('admin_produit',[
                // on envoi l'id du produit
                'id' => $produit->getId()
            ]);
        }
        
        return $this->render('admin/produit_form.html.twig',[
            'formProduit' => $form->createView(),
            'editMode' => $produit->getId() !== null,
        ]);
    }
    /**
     * @Route("/admin/atelier/add", name="admin_atelier_add")
     * @Route("/admin/atelier/{id}/edit", name="admin_atelier_edit")
     */
        // On demande a Symfony de nous passer un produit qui peut etre null, puis ce preparer a receptionner une requete et la soumettre avec le manager
        public function adminAtelier(Atelier $atelier = null, Request $request, EntityManagerInterface $manager)
        {
            // si le produit n'existe pas, on initialise un nouveau produit, sinon le formulaire sera hydrater par le produit
            if(!$atelier){
                $atelier = new Atelier();
            }
            // creation du formulaire
            $form = $this->createForm(AtelierFormType::class, $atelier);
            // traiter les info du formulaire
            $form->handleRequest($request);
            // si le formulaire est soumis et valide
            if($form->isSubmitted() && $form->isValid()){
                // si le produit n'existe pas initalise la date d'enregistrement
                if(!$atelier->getId()){
                    $atelier->setDateEnregistrement(new \DateTime());
                }
                // le manager se prepare a enregistrer l'article
                $manager->persist($atelier);
                // le manager envoie la requete à la base
                $manager->flush();
                // redirection automatique 
                return $this->redirectToRoute('admin/atelier_index.html.twig',[
                    // on envoi l'id du produit
                    'id' => $atelier->getId()
                ]);
            }
            
            return $this->render('admin/atelier_form.html.twig',[
                'formAtelier' => $form->createView(),
                'editMode' => $atelier->getId() !== null,
            ]);
        }
}
