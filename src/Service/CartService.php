<?php

namespace App\Service;

use App\Entity\Cart;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class CartService
{
    private EntityManagerInterface $entityManager;
    private ?User $user;
    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->user = $security->getUser();
    }
    private function getUserCart():Cart
    {
        $cart = $this->entityManager->getRepository(Cart::class)->findOneBy(['user'=>$this->user]);
        if(!$cart){
            $cart = new Cart();
            $cart->setUser($this->user);
            $this->entityManager->persist($cart);
            $this->entityManager->flush();
        }
        return $cart;
    }

    public function addItem(int $productId, int $quantity):void
    {
        $product = $this->entityManager->getRepository(Product::class)->find($productId);
        if(!$product){
            return;
        }
        $cart = $this->getUserCart();
        $orderItem = new OrderItem();
        $orderItem->setCart($cart);
        $orderItem->setQuantity($quantity);
        $orderItem->setProduct($product);
        $cart->addItem($orderItem);
        $this->entityManager->persist($orderItem);
        $this->entityManager->flush();
    }

    public function removeItem(int $itemId): void
    {
        $cart = $this->getUserCart();
        foreach ($cart->getItems() as $item) {
            if ($item->getId() === $itemId) {
                $cart->removeItem($item);
                $this->entityManager->remove($item);
                break;
            }
        }
        $this->entityManager->flush();
    }
    public function getCartItems(): array
    {
        return $this->getUserCart()->getItems()->toArray();
    }

    public function updateItemQuantity(int $itemId, int $itemQuantity): void
    {
        $cart = $this->getUserCart();
        foreach ($cart->getItems() as $item) {
            if ($item->getId() === $itemId) {
                $item->setQuantity($itemQuantity);
                $this->entityManager->persist($item);
                break;
            }
        }
        $this->entityManager->flush();
    }
    public function getTotal(): float
    {
        $total = 0;
        /** @var OrderItem $item */
        foreach ($this->getCartItems() as $item){
            $total += $item->getProduct()->getPrice() * $item->getQuantity();
        }
        return $total;
    }
}