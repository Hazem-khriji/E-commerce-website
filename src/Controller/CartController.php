<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart'),IsGranted("ROLE_USER")]
    public function index(CartService $cartService, Request $request): Response
    {
        $items = $cartService->getCartItems();
        $total = $cartService->getTotal();
        return $this->render('cart/cart.html.twig', [
            'items'=> $items,
            'total'=>$total,
            'controller_name' => 'CartController'
        ]);
    }
    #[Route('/cart/add/{id}', name: 'add_cart',  methods: ['POST']),IsGranted("ROLE_USER")]
    public function add(int $id, CartService $cartService, Request $request): RedirectResponse
    {
        $cartService->addItem($id, $request->request->get('quantity'));
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/{id}', name: 'remove_cart'),IsGranted("ROLE_USER")]
    public function remove(int $id, CartService $cartService): RedirectResponse
    {
        $cartService->removeItem($id);
        $this->addFlash('info', "Item removed successfully");
        return $this->redirectToRoute('app_cart');
    }
    #[Route('/update', name: 'update_cart'),IsGranted("ROLE_USER")]
    public function updateCart(CartService $cartService, Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $formData = $request->request->all();
            if(isset($formData['quantities'])){
                $quantities = $formData['quantities'];
                foreach ($quantities as $id => $quantity) {
                    $cartService->updateItemQuantity($id, $quantity);
                }
            }
        }
        return $this->redirectToRoute('app_cart');
    }
}
