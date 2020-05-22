<?php

namespace App\Controller;

use App\Entity\Produit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{
    /**
     * @Route("/commande", name="commande")
     */
    public function index()
    {
        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }
     /**
     * @Route("/panier/add{id}", name="panier_add")
     */
    public function panierAdd(Request $request, $id)
    {
        $produit = $this->getDoctrine()->getManager()->find(Produit::class, $id);
$quantite = $request ->request->get('quantite');
$session = $request->getSession();
if(!$session ->has('panier')){

    $session->set('panier', []);
}
$panier = $session->get('panier');
$panier[] = array(
    'produit' => $produit,
    'quantite' => $quantite);

    $session->set('panier', $panier);

    $this->addFlash('success', 'Le produit à été ajouté au panier');
       return $this->redirectToRoute('panier');
    }

}
