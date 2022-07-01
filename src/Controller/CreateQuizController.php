<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categorie;
use App\Entity\Question;
use App\Entity\Reponse;
use App\Form\QuestionType;
use App\Form\CategorieType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class CreateQuizController extends AbstractController
{
    #[Route('/create', name: 'app_create_quiz', methods:['GET', 'POST'])]
    public function createQ(Request $request, EntityManagerInterface $em): Response
    {
        $question = new Question();
        $categorie = new Categorie();
        $form = $this->createForm(QuestionType::class, $question);
        $formC = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);
        $formC->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $question = $form->getData();
            $em->persist($question);
            $em->flush();

            $this->addFlash(
                'success',
                'Votre quiz a bien été créé !'
            );

            $this->redirectToRoute('app_quiz');
        }

        if($formC->isSubmitted() && $formC->isValid())
        {
            $categorie = $formC->getData();
            $em->persist($categorie);
            $em->flush();

            $this->redirectToRoute('app_quiz');
        }
        return $this->render('create_quiz/index.html.twig', [
            'formQ' => $form->createView(),
            'formC' => $formC->createView()
        ]);
    }
}
