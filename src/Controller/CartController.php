<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use App\Services\CartService;
use Symfony\Component\Security\Http\Attribute\IsGranted;


final class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart'),IsGranted("ROLE_USER")]
    public function show(CartService $cartService)
    {
        return $this->render('cart/cart.html.twig', [
            'items' => $cartService->getCartWithData(),
            'total' => $cartService->getTotal()
            ]);
    }
    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add($id, CartService $cartService)
    {
        $cartService->add($id);
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function remove($id, CartService $cartService)
    {
        $cartService->remove($id);
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/clear', name: 'cart_clear')]
    public function clear(CartService $cartService)
    {
        $cartService->clear();
        return $this->redirectToRoute('app_cart');
    }
    #[Route('/cart/update/{id}', name: 'cart_update', methods: ['POST'])]
    public function update(Request $request, $id, CartService $cartService): Response
    {
        $quantity = (int) $request->request->get('quantity');

        if ($quantity >= 1) {
            $cartService->update($id, $quantity);
        }

        if ($request->isXmlHttpRequest()) {
            return new Response('OK');
        }

        return $this->redirectToRoute('app_cart');
    }
}
