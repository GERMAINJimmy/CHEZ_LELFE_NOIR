<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Promotion;
use App\Entity\Commentaire;
use App\Entity\User;
use App\Repository\ProduitRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\CommentaireFormType;
use App\Repository\PromotionRepository;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="produit")
     */
    public function index(ProduitRepository $repo, Request $request, PaginatorInterface $paginator, PromotionRepository $production)
    {
        // Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
        $donnees = $this->getDoctrine()->getRepository(Produit::class)->findBy([], ['dateEnregistrement' => 'desc']);


        //On appele la liste de tout les produitss
        $nouveautes = $repo->findBy([], ['dateEnregistrement' => 'desc'], $limit = 3);
        $promotions = $this->getDoctrine()->getRepository(Promotion::class)->findBy([], ['dateModification' => 'desc'], $limit = 3);
        // $promotions = $this->getDoctrine()->getRepository(Promotion::class)->findAllPromotion();
        $promos = $this->getDoctrine()->getRepository(Promotion::class)->findPrixPromotion();
        //On met en place la pagination
        $produits = $paginator->paginate($donnees, $request->query->getInt('page', 1), 12);
        //dd($promotions);
        return $this->render('produit/index.html.twig', [
            'produits' => $produits,
            'nouveautes' => $nouveautes,
            'promotions' => $promotions,
            'promos' => $promos,
        ]);
    }
    /**
     * @Route("/produit/{slug}", name="produit_show")
     */
    public function show($slug, Request $request)
    {
        // On récupère le produit correspondant au slug
        $produit = $this->getDoctrine()->getRepository(Produit::class)->findOneBy(['slug' => $slug]);

        // On récupère les commentaires actifs du produit
        $commentaires = $this->getDoctrine()->getRepository(Commentaire::class)->findBy([
            'produit' => $produit,
            'actif' => 1
        ], ['dateEnregistrement' => 'desc']);

        // On recupere les produits similaires
        $exemples = $this->getDoctrine()->getRepository(Produit::class)->findBy([], ['dateEnregistrement' => 'desc'], $limit = 3);


        if (!$produit) {
            // Si aucun produit n'est trouvé, nous créons une exception
            throw $this->createNotFoundException('Le produit n\'existe pas');
        }

        // Nous créons l'instance de "Commentaires"
        $commentaire = new Commentaire();

        // Nous créons le formulaire en utilisant "CommentairesType" et on lui passe l'instance
        $form = $this->createForm(CommentaireFormType::class, $commentaire);

        // Nous récupérons les données
        $form->handleRequest($request);

        // Nous vérifions si le formulaire a été soumis et si les données sont valides
        if ($form->isSubmitted() && $form->isValid()) {
            // Hydrate notre commentaire avec le produit
            $commentaire->setProduit($produit);
            $commentaire->setActif(0);
            $commentaire->setUser(null);


            $doctrine = $this->getDoctrine()->getManager();

            // On hydrate notre instance $commentaire
            $doctrine->persist($commentaire);

            // On écrit en base de données
            $doctrine->flush();

            // On redirige l'utilisateur
            return $this->redirectToRoute('produit_show', ['slug' => $slug]);
        }

        // Si le produit existe nous envoyons les données à la vue
        return $this->render('produit/show.html.twig', [
            'form' => $form->createView(),
            'produit' => $produit,
            'commentaires' => $commentaires,
            'exemples' => $exemples,
        ]);
    }
}
