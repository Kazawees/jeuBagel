<?php

namespace App\Controller;

use App\Repository\GamerRepository;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OriginalController extends AbstractController
{
    #[Route('/original/{id<[0-9]+>}', name: 'app_original')]
    public function index(int $id,QuestionRepository $questionRepository, GamerRepository $gamerRepository): Response
    {
        if($id===11)
        {
            return $this->redirectToRoute('app_choose');
        }

        
        //random min et max
        $minGamerId = $gamerRepository->countGamers()['min'];
        $maxGamerId = $gamerRepository->countGamers()['max'];

        $minQuestionId = $questionRepository->countQuestions()['min'];
        $maxQuestionId = $questionRepository->countQuestions()['max'];


        if($id === 10)
        {
            $question = 'Partie terminée';
        }
        else{
            $question = $questionRepository->find(mt_rand($minQuestionId, $maxQuestionId))->getQuestion();
        }

        $id = $id + 1;



        //Là tu dois faire if $id =10 alor return redirect(index) par exmeple
       
        return $this->render('original/index.html.twig', [
            'numero_question' => $id,
            'question'=>$question,
            'gamer'=>$gamerRepository->find(mt_rand($minGamerId, $maxGamerId))
        ]);
    }
}
