<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class CheckoutController extends AbstractController
{
    #[Route('/checkout', name: 'app_checkout'),IsGranted("ROLE_USER")]
    public function index(): Response
    {
        return $this->render('checkout/checkout.html.twig', [
            'controller_name' => 'CheckoutController',
        ]);
    }
}
