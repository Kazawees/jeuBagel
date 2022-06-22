<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TurbocuiteController extends AbstractController
{
    #[Route('/turbocuite', name: 'app_turbocuite')]
    public function index(): Response
    {
        return $this->render('turbocuite/index.html.twig', [
            'controller_name' => 'TurbocuiteController',
        ]);
    }
}
