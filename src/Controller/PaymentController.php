<?php

namespace App\Controller;

use App\Services\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'app_payment')]
    public function index(): Response
    {
        return $this->render('payment/index.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }

    #[Route('/checkout', name: 'app_checkout')]
    public function checkout(CartService $cartService): Response
    {
        $items = $cartService->getCartWithData();
        $lineItems = [];
        foreach ($items as $item) {
            $product = $item['product'];
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product->getName(),
                        'description' => $product->getDescription(),
                    ],
                    'unit_amount' => (int)($product->getPrice() * 100),
                ],
                'quantity' => $item['quantity'],
            ];
        }

        $stripe = new \Stripe\StripeClient("xxxxxxxxxxxxxxxxxxxxxxx");
        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => $this->generateUrl('app_thank_you', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('app_cancel', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return $this->redirect($checkout_session->url, 303);
    }
}