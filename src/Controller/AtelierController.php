<?php

namespace App\Controller;

use App\Entity\Atelier;
use App\Repository\AtelierRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AtelierController extends AbstractController
{
    /**
     * @Route("/atelier", name="atelier")
     */
    public function index(AtelierRepository $repo)
    {
        //On appele la liste de tout les articles
        $ateliers = $repo->findAll();
        return $this->render('atelier/index.html.twig', [
            'ateliers' => $ateliers,
        ]);
    }
    /**
    * @Route("/atelier/{slug}", name="atelier_show")
    */
    public function show(atelier $atelier)
    {
        return $this->render('atelier/show.html.twig',[
                'atelier' => $atelier,
        ]);
    }
}
