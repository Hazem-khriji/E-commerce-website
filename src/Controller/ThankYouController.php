<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ThankYouController extends AbstractController
{
    #[Route('/thank/you', name: 'app_thank_you')]
    public function index(): Response
    {
        return $this->render('thankyou/thankyou.html.twig', [
            'controller_name' => 'ThankYouController',
        ]);
    }
}
