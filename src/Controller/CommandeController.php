<?php

namespace App\Controller;

use App\Entity\Produit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Flex\Command\RemoveCommand;

class CommandeController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     */
    public function panier(Request $request)
    {
        
        return $this->render('commande/panier.html.twig', []);
    }

    /**
     * @Route("/panier/add/{id}", name="panier_add")
     */
    public function add($id, Request $request)
    {
        $nbExemplaires = $request->request->get('quantite'); // Récupération de la quantité en post

        // Récupération du produit concerné
        $manager = $this->getDoctrine()->getManager();
        $produit = $manager->find(Produit::class,$id);  //objet existant

        $session = $request->getSession();
        
        if(!$session->has('panier'))
        {
            // Pas de panier, on créé
            $session->set('panier', array());    
        } 
        // On ajoute l'élement dans le panier
        $panier = $session->get('panier');
        $panier[] = array('produit'=>$produit, 'nbExemplaires' => $nbExemplaires);
        $session->set('panier', $panier);

        $this->addFlash('success', "<b>" . $nbExemplaires . "</b> exemplaire(s) du produit <b>".$produit->getTitre()."</b> ajouté(s) au panier.");
        return $this->redirectToRoute('panier');
    }

    /**
     * 
     */
    //@Route("/panier/add/{id}/{nbExemplaires}", name="panier_add")
    // public function add($id,$nbExemplaires, Request $request)
    // {
    //     // Récupération du produit concerné
    //     $manager = $this->getDoctrine()->getManager();
    //     $produit = $manager->find(Produit::class,$id);  //objet existant

    //     $session = $request->getSession();
        
    //     if(!$session->has('panier'))
    //     {
    //         // Pas de panier, on créé
    //         $session->set('panier', array());    
    //     } 
    //     // On ajoute l'élement dans le panier
    //     $panier = $session->get('panier');
    //     $panier[] = array('produit'=>$produit, 'nbExemplaires' => $nbExemplaires);
    //     $session->set('panier', $panier);

    //     $this->addFlash('success', "<b>" . $nbExemplaires . "</b> exemplaire(s) du produit <b>".$produit->getTitre()."</b> ajouté(s) au panier.");
    //     return $this->redirectToRoute('panier');
    // }

    /**
     * @Route("/panier/valider", name="panier_valider")
     */
    // @Route("/commande/panierValidation", name="panier_validation")
    // public function panierValidation(Request $request)
    public function valider(Request $request)
    {
        
        return $this->render('commande/panier.html.twig', []);
    }

    /**
     * @Route("/panier/vider", name="panier_vider")
     */
    //@Route("/commande/panierVider", name="panier_vider")
    // public function panierVider(Request $request)
    public function vider(Request $request)
    {
        $session = $request->getSession();
        $session->remove('panier');

        $this->addFlash('success', "Le panier a été vidé.");
        return $this->redirectToRoute('panier');
    }
}
