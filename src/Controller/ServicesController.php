<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ServicesController extends AbstractController
{
    #[Route('/services', name: 'app_services'),IsGranted("ROLE_USER")]
    public function index(): Response
    {
        return $this->render('services/services.html.twig', [
            'controller_name' => 'ServicesController',
        ]);
    }
}
