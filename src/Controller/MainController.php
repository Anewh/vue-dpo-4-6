<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/{path}', name: 'app_homepage', requirements: ['path' => '.*'])]
    public function index(): Response
    {
        return $this->render('main/index.html.twig');
    }
}
