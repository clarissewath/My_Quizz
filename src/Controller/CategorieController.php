<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categorie;

use Doctrine\Persistence\ManagerRegistry;


class CategorieController extends AbstractController
{
    #[Route('/', name: 'app_categorie')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $manager = $doctrine->getManager();
        $categorie = $manager->getRepository(Categorie::class)->findAll();

        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
            'categorie' => $categorie,
        ]);
    }
}
