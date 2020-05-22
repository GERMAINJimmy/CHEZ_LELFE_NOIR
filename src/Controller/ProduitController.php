<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Promotion;
use App\Repository\ProduitRepository;
use App\Repository\PromotionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="produit")
     */
    public function index(ProduitRepository $repo, PromotionRepository $promo, Request $request, PaginatorInterface $paginator)
    {
        // Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
        $donnees = $this->getDoctrine()->getRepository(Produit::class)->findBy([],['dateEnregistrement' => 'desc']);
        
        
        //On appele la liste de tout les articles
        $nouveautes = $repo->findBy([],['dateEnregistrement' => 'desc'],$limit = 3);
        $promotions = $promo->findBy([],['dateEnregistrement' => 'desc'],$limit = 3);
        
        //On met en place la pagination
        $produits = $paginator->paginate($donnees,$request->query->getInt('page', 1),12);

        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
            'nouveautes' => $nouveautes,
            'promotions' => $promotions,
        ]);
    }

    /**
     * @Route("/produit/{slug}", name="produit_show")
     */
    public function show(PromotionRepository $promo, Produit $produit){
        $promotion = $promo->find($produit);
        return $this->render('produit/promotion.html.twig',[
            'promotion' => $promotion,
            'produit' => $produit,
        ]);
    }
}
