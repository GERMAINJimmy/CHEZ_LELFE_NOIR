<?php

namespace App\Controller;

use App\Entity\Atelier;
use App\Repository\AtelierRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Commentaire;
use App\Form\CommentaireFormType;




class AtelierController extends AbstractController
{
    /**
     * @Route("/atelier", name="atelier")
     */
    public function index(AtelierRepository $repo)
    {
        //On appele la liste de tout les ateliers
        $ateliers = $repo->findAll();
        return $this->render('atelier/index.html.twig', [
            'ateliers' => $ateliers,
        ]);
    }
    /**
    * @Route("/atelier/{slug}", name="atelier_show")
    */
    public function show($slug, Request $request){
        // On récupère l'atelier correspondant au slug
        $atelier = $this->getDoctrine()->getRepository(Atelier::class)->findOneBy(['slug' => $slug]);
    
        // On récupère les commentaires actifs de l'atelier
        $commentaires = $this->getDoctrine()->getRepository(Commentaire::class)->findBy([
            'atelier' => $atelier,
            'actif' => 1
        ],['dateEnregistrement' => 'desc']);
    
        if(!$atelier){
            // Si aucun atelier n'est trouvé, nous créons une exception
            throw $this->createNotFoundException('L\'atelier n\'existe pas');
        }
        
        // Nous créons l'instance de "Commentaires"
        $commentaire = new Commentaire();
    
        // Nous créons le formulaire en utilisant "CommentairesType" et on lui passe l'instance
        $form = $this->createForm(CommentaireFormType::class, $commentaire);
    
        // Nous récupérons les données
        $form->handleRequest($request);
    
        // Nous vérifions si le formulaire a été soumis et si les données sont valides
        if ($form->isSubmitted() && $form->isValid()) {
        // Hydrate notre commentaire avec l'atelier
        $commentaire->setAtelier($atelier);
        $commentaire->setActif(0);
        $commentaire->setUser(null);
    
        
        $doctrine = $this->getDoctrine()->getManager();
    
        // On hydrate notre instance $commentaire
        $doctrine->persist($commentaire);
    
        // On écrit en base de données
        $doctrine->flush();
    
        // On redirige l'utilisateur
        return $this->redirectToRoute('atelier_show', ['slug' => $slug]);
        }
        
        // Si l'atelier existe nous envoyons les données à la vue
        return $this->render('atelier/show.html.twig',[
            'form' => $form->createView(),
            'atelier' => $atelier,
            'commentaires' => $commentaires,
        ]);
    }
}
