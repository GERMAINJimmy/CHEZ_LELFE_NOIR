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
}
