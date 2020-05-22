<?php

namespace App\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index()
    {
        return $this->render('accueil/index.html.twig',[
        ]);
    }

    /**
     * @Route("/mentions-legales", name="mentions-legales")
     */
    public function mentionsLegales()
    {
        // Nous générons la vue de la page des mentions légales
        return $this->render('accueil/mentions-legales.html.twig');
    }

    /**
     * @Route("/politique-confidentialite", name="politique-confidentialite")
     */
    public function politiqueConfidentialite()
    {
        // Nous générons la vue de la page de la politique  de confidentialite
        return $this->render('accueil/politique-confidentialite.html.twig');
    }

    /**
     * @Route("/cgv", name="cgv")
     */
    public function cgv()
    {
        // Nous générons la vue de la page des cgv
        return $this->render('accueil/cgv.html.twig');
    }

    /**
     * @Route("/qui-sommes-nous", name="qui-sommes-nous")
     */
    public function quiSommesNous()
    {
        // Nous générons la vue de la page qui sommes nous ?
        return $this->render('accueil/qui-sommes-nous.html.twig');
    }

    /**
     * @Route("/recrutement", name="recrutement")
     */
    public function recrutement()
    {
        // Nous générons la vue de recrutement
        return $this->render('accueil/recrutement.html.twig');
    }
    
    /**
     * @Route("/plan", name="plan")
     */
    public function plan()
    {
        // Nous générons la vue du plan du site
        return $this->render('accueil/plan.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        // Nous générons la vue du contact du site
        return $this->render('accueil/contact.html.twig');
    }
}
