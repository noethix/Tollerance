<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/accueil", name="home")
     */
    public function home()
    {
        return $this->render('home/home.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/accueil/groupes", name="home_groups")
     */
    public function homeGroups()
    {
        return $this->render('home/homegroups.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/accueil/toutsurnous", name="home_about_us")
     */
    public function homeAboutUs()
    {
        return $this->render('home/homeaboutus.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/accueil/infos", name="home_infos")
     */
    public function homeInfos()
    {
        return $this->render('home/homeinfos.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/accueil/suite", name="home_suite")
     */
    public function homeSuite()
    {
        return $this->render('home/homesuite.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/accueil/links", name="home_links")
     */
    public function homeLinks()
    {
        return $this->render('home/homelinks.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
