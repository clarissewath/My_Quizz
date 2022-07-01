<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Reponse;
use App\Entity\Categorie;
use DateTime;

class ResultatController extends AbstractController
{
    #[Route('/resultat', name: 'app_resultat')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $manager = $doctrine->getManager();
        $reponse = $manager->getRepository(Reponse::class)->findAll();
        $request = Request::createFromGlobals();
        $res = $request->query->get('res');
        $id = $request->query->get('id');

        $tab = explode("/", substr($res, 1));
        // dd($tab);

        $categorie = $manager->getRepository(Categorie::class)->findBy(array('id' => $id));

        $count = 0;
        $count2 = 0;
        $score = 0;
        $resultat = [];
        foreach ($tab as $tabs) {

            foreach ($manager->getRepository(Reponse::class)->findBy(array('id' => $tab[$count])) as $vamu) {
                $resultat[] = $vamu;
            }
            $count++;
        }

        // dd($resultat);
        foreach ($resultat as $resultats) {
            if ($resultats->getReponseExpected() === true) {
                $score += 1;
            }
        }


        $scorecookie = $id . '|' . $score . '/' . $count . '|' . date('Y-m-d H:i:s');

        setcookie($id, $scorecookie, time() + (86400 * 30), "/");

        return $this->render('resultat/index.html.twig', [
            'controller_name' => 'ResultatController',
            'reponse' => $reponse[1],
            'score' => $score,
            'count' => $count,
            'catégorie' => $categorie,
        ]);
    }
}
