<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Promotion;
use App\Repository\ProduitRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="produit")
     */
    public function index(ProduitRepository $repo, Request $request, PaginatorInterface $paginator)
    {
        // Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
        $donnees = $this->getDoctrine()->getRepository(Produit::class)->findBy([],['dateEnregistrement' => 'desc']);
        
        
        //On appele la liste de tout les articles
        $nouveautes = $repo->findBy([],['dateEnregistrement' => 'desc'],$limit = 3);
        $promotions = $this->getDoctrine()->getRepository(Promotion::class)->findBy([],['dateEnregistrement' => 'desc'],$limit = 3);
        $promos = $this->getDoctrine()->getRepository(Promotion::class)->findAll();
        
        //On met en place la pagination
        $produits = $paginator->paginate($donnees,$request->query->getInt('page', 1),12);
        //dd($promotions);
        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
            'nouveautes' => $nouveautes,
            'promotions' => $promotions,
            'promos' => $promos,
            ]);
        }
        
        /**
        * @Route("/{slug}", name="article")
        */
    /*public function article($slug){
        // On récupère l'article correspondant au slug
        $article = $this->getDoctrine()->getRepository(Articles::class)->findOneBy(['slug' => $slug]);
        if(!$article){
            // Si aucun article n'est trouvé, nous créons une exception
            throw $this->createNotFoundException('L\'article n\'existe pas');
        }
        // Si l'article existe nous envoyons les données à la vue
        return $this->render('articles/article.html.twig', compact('article'));
    }*/
        
        /**
         * @Route("/produit/{slug}", name="produit_show")
         */
        public function show(Produit $produit){
        return $this->render('produit/show.html.twig',[
            'produit' => $produit,
        ]);
    }
}
