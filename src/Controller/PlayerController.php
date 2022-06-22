<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Gamer;
use App\Entity\Player;
use App\Form\PlayerType;
use App\Repository\PlayerRepository;
use App\Repository\GamerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class PlayerController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(PlayerRepository $playerRepository): Response
    {
        return $this->render('player/index.html.twig', [
            'players' => $playerRepository->findAll()
        ]);
    }
    #[Route('/create', name: 'player_create')]
    public function create(Request $request, ManagerRegistry $doctrine, GamerRepository $gamerRepository): Response
    {
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player)->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($player);
            $em->flush();
            return $this->redirectToRoute("app_choose");
        }
        
        return $this->render('player/create.html.twig', [
            "form" => $form->createView(),
            'gamers' => $gamerRepository->findAll()
        ]);
    }

    #[Route('/delete/{id<[0-9]+>}', name: 'player_delete')]
    public function delete(Gamer $id, EntityManagerInterface $em): Response
    {
        $em->remove($id);
        $em->flush();
        
        return $this->redirectToRoute("player_create");
    }
    
}
