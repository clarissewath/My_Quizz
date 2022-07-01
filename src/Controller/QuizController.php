<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Question;
use App\Entity\Reponse;

class QuizController extends AbstractController
{
    #[Route('/quiz', name: 'app_quiz')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $request = Request::createFromGlobals();
        $id = $request->query->get('id');
        $quest = $request->query->get('question');
        $res = $request->query->get('res');

        $manager = $doctrine->getManager();
        $question = $manager->getRepository(Question::class)->findBy(array('id_categorie' => $id));
        $response = [];
        foreach ($question as $questions) {
            $response[] = $manager->getRepository(Reponse::class)->findBy(array('id_question' => $questions->getId()));
        }
        if(empty($question[$quest - 1])){
            header("Location: /resultat" . "?res=" . $res . "&id=" . $id);
            setcookie($id, '', time() + (86400 * 30), "/");
            exit();
        }
        $responseReturn = $response[$quest - 1];
        shuffle($responseReturn);
        

        return $this->render('quiz/index.html.twig', [
            'controller_name' => 'QuizController',
            'question' => $question[$quest - 1],
            'reponse' => $responseReturn,
            'request' => $request,
        ]);

    }
}
