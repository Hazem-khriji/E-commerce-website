<?php

namespace App\Controller;

use App\Services\CartService;
use Stripe\Stripe;
use Stripe\Checkout\Session;
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
        // Set your Stripe secret key (make sure it's loaded in your env variables)
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

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

        $checkoutSession = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => $this->generateUrl('app_thank_you', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('app_cancel', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return $this->redirect($checkoutSession->url, 303);
    }
}

