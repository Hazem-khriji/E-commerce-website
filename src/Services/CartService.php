<?php



namespace App\Services;
use App\Repository\OrderRepository ;
use App\Repository\ProductRepository ;
use App\Repository\OrderItemRepository ;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    private $session;
   // private OrderRepository $orderRepository;
    private ProductRepository $productRepository;

    public function __construct(RequestStack $requestStack, ProductRepository $productRepository){
        $this->session = $requestStack->getSession();
        $this->productRepository = $productRepository;
    }

    public function add (int $productId){
        $cart = $this->session->get('cart', []);
        $cart[$productId] = ($cart[$productId] ?? 0) + 1;
        $this->session->set('cart', $cart);
    }

    public function remove(int $productId){
        $cart = $this->session->get('cart', []);
        unset($cart[$productId]);
        $this->session->set('cart', $cart);
    }

    public function getCartWithData(): array{
        $cart = $this->session->get('cart', []);
        $cartWithData = [];
        foreach ($cart as $Id => $quantity){
            $product = $this->productRepository->find($Id);
            if($product){
                $cartWithData[$Id] = [
                    'product' => $product,
                    'quantity' => $quantity,
                ];
            }
        }
        return $cartWithData;
    }

    public function removeAll(){
        $cart = $this->session->get('cart', []);
        unset($cart);
    }

//    public function getTotal():float {
//        $cart = $this->session->get('cart', []);
//        $total = 0;
//        foreach ($cart as $Id => $quantity){
//            foreach ($this->getCartWithData() as $item) {
//                $total += $item['product']->getPrice() * $item['quantity'];
//            }
//        }
//        return $total;
//    }
    public function getTotal(): float {
        $cartWithData = $this->getCartWithData();
        $total = 0;

        foreach ($cartWithData as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }

        return $total;
    }

    public function clear(): void
    {
        $this->session->remove('cart');
    }
    public function update(int $id, int $quantity): void
    {
        $cart = $this->session->get('cart', []);

        if (isset($cart[$id])) {
            if ($quantity > 0) {
                $cart[$id] = $quantity;
            } else {
                unset($cart[$id]);
            }
        }

        $this->session->set('cart', $cart);
    }
}